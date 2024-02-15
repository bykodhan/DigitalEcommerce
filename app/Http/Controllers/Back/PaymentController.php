<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductDetail;
use App\Models\ProductStock;
use Cache;
use Illuminate\Http\Request;
use URL;

class PaymentController extends Controller
{
    public function paymaxCallbackFailUrl()
    {
        echo 'Paymax Callback Fail Url';
    }
    public function paymaxCallbackOkUrl(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            if ($order->payment_status == 1) {
                if (Cache::get('telegram_bot_active') == 1) {
                    if ($order->option_name) {
                        $option_name = $order->option_name;
                    } else {
                        $option_name = '-';
                    }
                    $message = 'Sipariş No: ' . $order->order_id . ' Paymax ile ödendi. ' . $order->product_title . ' - ' . $option_name . ' - ' . $order->qty . ' Adet - ' . $order->amount_paid . ' TL' . ' - ' . $order->name . ' ' . $order->surname . ' - ' . $order->email . ' - ' . $order->phone;
                    telegram_bot_send_message($message);
                }
            }
            return redirect(URL::signedRoute('order.ok', ['order_id' => $order->order_id]))->with('success', 'Ödeme gerçekleştirildi');
        }
    }
    public function paymax_callback(Request $request)
    {
        /*
        DİKKAT 1 : Bu örnekleri değiştirmeden yada düzenlemeden sisteminizde kullanmayın. Bu kod yapısı sadece işleyiş ve senaryolar hakkında önizleme ve bilgi edinmeniz niteliğindedir.
        Post güvenliğinin sağlanması ve işleyişin ve entegrasyonun doğru bir şekilde yapılandırılması tamamen sizin sorumluluğunuzdadır.

        DİKKAT 2 : Bu sayfa müşterilerinizin göreceği bir sayfa değildir. Ödeme işlemi yapıldığında arka planda paymax servisleri ödemeyi bu sayfanıza bildirecektir.
        Ödemeyi sisteminize işlediğinizde ekrana OK cevabı vermelisiniz. Aksi bir durum yada hatada Sadece hata yada sorun ile ilgili kısa bit metin yazdırmanız yeterlidir.
         */

        $paymax_config = array(
            'userName' => Cache::get('paymax_api_user'),
            'password' => Cache::get('paymax_api_key'),
            'shopCode' => Cache::get('paymax_api_merchant'),
            'hash' => Cache::get('paymax_api_hash'),
        );

        $post = array();
        $post['status'] = $_POST['status'];
        $post['paymentStatus'] = $_POST['paymentStatus'];
        $post['hash'] = $_POST['hash'];
        $post['paymentCurrency'] = $_POST['paymentCurrency'];
        $post['paymentAmount'] = $_POST['paymentAmount'];
        $post['paymentType'] = $_POST['paymentType'];
        $post['paymentTime'] = $_POST['paymentTime'];
        $post['conversationId'] = $_POST['conversationId'];
        $post['orderId'] = $_POST['orderId'];
        $post['shopCode'] = $_POST['shopCode'];
        $post['orderPrice'] = $_POST['orderPrice'];
        $post['productsTotalPrice'] = $_POST['productsTotalPrice'];
        $post['productType'] = $_POST['productType'];
        $post['callbackOkUrl'] = $_POST['callbackOkUrl'];
        $post['callbackFailUrl'] = $_POST['callbackFailUrl'];

        if (empty($post['status']) || empty($post['paymentStatus']) || empty($post['hash']) || empty($post['paymentCurrency']) || empty($post['paymentAmount']) || empty($post['paymentType']) || empty($post['orderId']) || empty($post['shopCode']) || empty($post['orderPrice']) || empty($post['productsTotalPrice']) || empty($post['productType']) || empty($post['callbackOkUrl']) || empty($post['callbackFailUrl'])) {
            /*Eksik Form Datası Mevcut*/
            echo 'EKSIK_FORM_DATASI';
            exit();
        } else {
            $hash_string = $post['orderId'] . $post['paymentCurrency'] . $post['orderPrice'] . $post['productsTotalPrice'] . $post['productType'] . $paymax_config["shopCode"] . $paymax_config["hash"];
            $MY_HASH = base64_encode(pack('H*', sha1($hash_string)));
            if ($MY_HASH !== $post['hash']) {
                /*Hash Uyuşmuyor*/
                echo 'HATALI_HASH_IMZASI';
                exit();
            } else {
                /*
                paymentStatus'un alabileceği değerler =
                paymentWait(Ödeme Bekleniyor),
                paymentVerification(Ödendi ancak ödeme doğrulama bekliyor. Reddedilebilir. Mal yada hizmetinizi müşterinize paymentOk alana kadar vermeyin),
                paymentOk(Ödeme alındı. Artık mal yada hizmetinizi müşterinize verebilirsiniz),
                paymentNotPaid('Ödenmedi'),
                 */
                if ($post['paymentStatus'] == 'paymentOk') {

                    /*Sipariş bilginizi sisteminizden çekin ve doğrulayın*/
                    $order = Order::where('order_id', $post['orderId'])->first();
                    if ($order->order_status == 0) {
                        $order_status = 'ODEME_BEKLIYOR';
                    }
                    $siparisler = array(
                        $order->order_id => array(
                            'odemeDurumu' => $order_status,
                            'tutar' => $order->amount_paid, //ondalık değeri 2 hane olarak alın
                            'paraBirimi' => 'TRY',
                        ),
                    );
                    /*Bu alanda sipariş bilgilerinizi veritabanınızdan çektiğinizi varsayalım ve doğrulama işlemlerine devam edelim*/

                    if (!$siparisler[$post['orderId']]) {
                        /*Böyle bir sipariş sistemimde yok*/
                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                        exit();
                    } else if ($siparisler[$post['orderId']]['odemeDurumu'] == 'ODENDI') {
                        /*Zaten ödenmiş ve işlenmiş*/
                        if ($order->stock_content) {
                            $order->order_status = 2;
                        } else {
                            $order->order_status = 1;
                        }
                        $order->payment_status = 1;
                        $order->save();

                        echo 'OK';
                        exit();
                    } else if ($siparisler[$post['orderId']]['tutar'] != $post['paymentAmount']) {
                        echo 'TUTAR_HATALI';
                        exit();
                    } else {
                        /*Ödemeyi sisteminize işleyin*/
                        $odemeyi_isle = 'Burada veritabanınızı yada sisteminizdeki siparişi ödendi olarak işleyin ve kaydedin.';
                        if ($odemeyi_isle) {
                            /*Ödeme işlendi ve başarılı*/
                            if ($order->stock_content) {
                                $order->order_status = 2;
                            } else {
                                $order->order_status = 1;
                            }
                            $order->payment_status = 1;
                            $order->save();
                            if ($order->coupon_code) {
                                $coupon = Coupon::where('code', $order->coupon_code)->first();
                                if ($coupon) {
                                    $coupon->usage_count = $coupon->usage_count + 1;
                                    $coupon->save();
                                }
                            }
                            echo 'OK';
                            exit();
                        } else {
                            /*
                            Ödeme işlenemedi. Hatanızı basın. Paymax bir kaç dakika sonra yeniden aynı ödeme için size bildirim gönderecektir.
                            Sisteminizin birden fazla hata vermesi yada OK cevabı dönmemesi durumunda paymax tarafından işyeri sahibi bilgilendirilecktir.
                             */
                            echo 'SIPARIS_ISLENEMEDI';
                            exit();
                        }
                    }
                }
            }
        }
    }

    public function paytr_callback()
    {
        $post = $_POST;

        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
        $merchant_key = Cache::get('paytr_merchant_key');
        $merchant_salt = Cache::get('paytr_merchant_salt');
        ###########################################################################

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        #
        ## POST değerleri ile hash oluştur.
        $hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));
        #
        ## Oluşturulan hash'i, paytr'dan gelen post içindeki hash ile karşılaştır (isteğin paytr'dan geldiğine ve değişmediğine emin olmak için)
        ## Bu işlemi yapmazsanız maddi zarara uğramanız olasıdır.
        if ($hash != $post['hash']) {
            die('PAYTR notification failed: bad hash');
        }

        ###########################################################################

        ## BURADA YAPILMASI GEREKENLER
        ## 1) Siparişin durumunu $post['merchant_oid'] değerini kullanarak veri tabanınızdan sorgulayın.
        ## 2) Eğer sipariş zaten daha önceden onaylandıysa veya iptal edildiyse  echo "OK"; exit; yaparak sonlandırın.

        // Sipariş durum sorgulama örnek
        $order = Order::where('order_id', $post['merchant_oid'])->first();
        if ($order->order_status == 1 || $order->order_status == 2 || $order->order_status == 3) {
            echo 'OK';
            exit();
        }

        if ($post['status'] == 'success') { ## Ödeme Onaylandı

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi onaylayın.
            ## 2) Eğer müşterinize mesaj / SMS / e-posta gibi bilgilendirme yapacaksanız bu aşamada yapmalısınız.
            ## 3) 1. ADIM'da gönderilen payment_amount sipariş tutarı taksitli alışveriş yapılması durumunda
            ## değişebilir. Güncel tutarı $post['total_amount'] değerinden alarak muhasebe işlemlerinizde kullanabilirsiniz.
            /*Ödeme işlendi ve başarılı*/
            $product_detail = ProductDetail::where('product_id', $order->product_id)->first();

            if ($product_detail->stock_type == 3) {
                $stocks = ProductStock::where('product_id', $order->product_id);
                if ($stocks->count() >= $order->qty) {
                    $stock = $stocks->take($order->qty)->get()->pluck('content')->implode(',');
                    $order->stock_type = 3;
                }
            }
            if ($product_detail->stock_type == 3) {
                $stocks->delete();
            }
            if (isset($stock)) {
                $order->stock_content = $stock;
            }
            if ($order->stock_content) {
                $order->order_status = 2;
            } else {
                $order->order_status = 1;
            }
            $order->payment_status = 1;
            $order->amount_paid = $post['total_amount'] / 100;
            $order->save();
            if ($order->coupon_code) {
                $coupon = Coupon::where('code', $order->coupon_code)->first();
                if ($coupon) {
                    $coupon->usage_count = $coupon->usage_count + 1;
                    $coupon->save();
                }
            }
            if (Cache::get('telegram_bot_active') == 1) {
                if ($order->option_name) {
                    $option_name = $order->option_name;
                } else {
                    $option_name = '-';
                }
                $message = 'Sipariş No: ' . $order->order_id . ' PayTR ile ödendi. ' . $order->product_title . ' - ' . $option_name . ' - ' . $order->qty . ' Adet - ' . $order->amount_paid . ' TL' . ' - ' . $order->name . ' ' . $order->surname . ' - ' . $order->email . ' - ' . $order->phone;
                telegram_bot_send_message($message);
            }

        } else { ## Ödemeye Onay Verilmedi

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi iptal edin.
            ## 2) Eğer ödemenin onaylanmama sebebini kayıt edecekseniz aşağıdaki değerleri kullanabilirsiniz.
            ## $post['failed_reason_code'] - başarısız hata kodu
            ## $post['failed_reason_msg'] - başarısız hata mesajı
            //$order->delete();
            echo $post['failed_reason_msg'];
            exit();
        }

        ## Bildirimin alındığını PayTR sistemine bildir.
        echo "OK";
        exit;
    }

    public function paytrCallbackOkUrl(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            if ($order->payment_status == 1) {
                return redirect(URL::signedRoute('order.ok', ['order_id' => $order->order_id]))->with('success', 'Ödeme gerçekleştirildi');
            } else {
                return redirect(URL::signedRoute('order.ok', ['order_id' => $order->order_id]))->with('error', 'Ödeme gerçekleştirilemedi');
            }
        }
    }
}
