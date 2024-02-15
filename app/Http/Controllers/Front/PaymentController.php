<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Cache;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    //Checkout
    public function payment(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order) {
            if ($order->option_name) {
                $product_title = $order->option_name . ' - ' . $order->product_title;
                $product_price = $order->option_price;
            } else {
                $product_title = $order->product_title;
                $product_price = $order->product_price;
            }
            if ($request->payment_method == 'papara') {
                $order->payment_method = 'papara';
                $papara_account = Cache::get('papara_account_number');
                $order->url = "https://www.papara.com/personal/qr?accountNumber=" . $papara_account . "&amount=" . $order->amount_paid . "&description=" . $order->order_id;
                $order->save();
                return redirect()->back()->with(['papara_account' => $papara_account, 'amount' => $order->amount_paid, 'order_id' => $order->order_id]);
            }
            if ($request->payment_method == 'paymax') {
                /*Sınıfı Api bilgilerinizle başlatın*/
                $order->payment_method = 'paymax';
                $paymax = [
                    'api_user' => Cache::get('paymax_api_user'),
                    'api_key' => Cache::get('paymax_api_key'),
                    'api_url' => Cache::get('paymax_api_url'),
                    'api_merchant' => Cache::get('paymax_api_merchant'),
                    'api_hash' => Cache::get('paymax_api_hash'),
                ];
                $paymax = new Paymax_light_api($paymax['api_user'], $paymax['api_key'], $paymax['api_merchant'], $paymax['api_hash']);
                /*Sipariş Bilgilerinizi Tanımlayın*/

                $order_data = array(
                    'productName' => $product_title,
                    'productData' => $product_title,
                    'productType' => 'DIJITAL_URUN',
                    'productsTotalPrice' => $order->amount_paid,
                    'orderPrice' => $order->amount_paid,
                    'currency' => 'TRY',
                    'orderId' => $order->order_id,
                    'locale' => 'tr',
                    'conversationId' => $order->order_id,
                    'buyerName' => $order->name,
                    'buyerSurName' => $order->surname,
                    'buyerGsmNo' => '0' . $order->phone,
                    'buyerIp' => $_SERVER['REMOTE_ADDR'],
                    'buyerMail' => $order->email,
                    'buyerAdress' => '',
                    'buyerCountry' => '',
                    'buyerCity' => '',
                    'buyerDistrict' => '',
                );
                /*Sipariş Bilgilerinizi link oluşturmak için sınıfa gönderin*/
                $response = $paymax->create_payment_link($order_data);
                if (isset($response['status']) == 'success' && isset($response['payment_page_url'])) {
                    /*status==success ve payment_page_url varsa başarılı bir işlem yürüttünüz*/
                    $odeme_link = $response['payment_page_url'];
                    $order->url = $odeme_link;
                    $order->save();
                    return redirect()->back()->with(['paymax_iframe_url' => $odeme_link]);

                } else {
                    /*Hatalı bir cevap alındı*/
                    // $order->delete();
                    print_r($response);
                    //return redirect()->back()->with('error','Paymax işlemi başarısız oldu. Lütfen tekrar deneyiniz');
                }
            }
            if ($request->payment_method == 'paytr') {
                ## 1. ADIM için örnek kodlar ##

                ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
                #
                ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
                $merchant_id = Cache::get('paytr_merchant_id');
                $merchant_key = Cache::get('paytr_merchant_key');
                $merchant_salt = Cache::get('paytr_merchant_salt');
                #
                ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
                $email = $order->email;
                #
                ## Tahsil edilecek tutar.
                $payment_amount = $order->amount_paid * 100; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
                #
                ## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
                $merchant_oid = $order->order_id;
                #
                ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
                $user_name = $order->name;
                #
                ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
                $user_address = "Türkiye";
                #
                ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
                $user_phone = $order->phone;
                #
                ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
                ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
                ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
                $merchant_ok_url = route('paytrCallbackOkUrl', ['order_id' => $order->order_id]);
                #
                ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
                ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
                ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
                $merchant_fail_url = route('paytrCallbackFailUrl');
                #
                ## Müşterinin sepet/sipariş içeriği

                $user_basket = base64_encode(json_encode(array(
                    array($product_title, $product_price, $order->qty), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
                )));
                #
                /* ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
                $user_basket = base64_encode(json_encode(array(
                array("Örnek ürün 1", "18.00", 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
                array("Örnek ürün 2", "33.25", 2), // 2. ürün (Ürün Ad - Birim Fiyat - Adet )
                array("Örnek ürün 3", "45.42", 1)  // 3. ürün (Ürün Ad - Birim Fiyat - Adet )
                )));
                 */
                ############################################################################################

                ## Kullanıcının IP adresi
                if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }

                ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
                ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
                $user_ip = $ip;
                ##

                ## İşlem zaman aşımı süresi - dakika cinsinden
                $timeout_limit = "30";

                ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
                $debug_on = 1;

                ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
                $test_mode = 0;

                $no_installment = 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

                ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
                ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
                $max_installment = 0;

                $currency = "TL";

                ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
                $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
                $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));
                $post_vals = array(
                    'merchant_id' => $merchant_id,
                    'user_ip' => $user_ip,
                    'merchant_oid' => $merchant_oid,
                    'email' => $email,
                    'payment_amount' => $payment_amount,
                    'paytr_token' => $paytr_token,
                    'user_basket' => $user_basket,
                    'debug_on' => $debug_on,
                    'no_installment' => $no_installment,
                    'max_installment' => $max_installment,
                    'user_name' => $user_name,
                    'user_address' => $user_address,
                    'user_phone' => $user_phone,
                    'merchant_ok_url' => $merchant_ok_url,
                    'merchant_fail_url' => $merchant_fail_url,
                    'timeout_limit' => $timeout_limit,
                    'currency' => $currency,
                    'test_mode' => $test_mode,
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);

                // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
                // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $result = @curl_exec($ch);

                if (curl_errno($ch)) {
                    die("PAYTR IFRAME connection error. err:" . curl_error($ch));
                }

                curl_close($ch);

                $result = json_decode($result, 1);

                if ($result['status'] == 'success') {
                    $token = $result['token'];
                    $odeme_link = "https://www.paytr.com/odeme/guvenli/" . $token;
                    return redirect()->back()->with(['paytr_iframe_url' => $odeme_link]);
                } else {
                    $order->delete();
                    return redirect()->route('index')->with('error', "Ödeme Gerçekleştirilmedi. Siparişiniz silindi tekrar oluşturunuz:" . $result['reason']);
                }

                #########################################################################

            }
            if ($request->payment_method == 'havale_eft') {
                $order->payment_method = 'havale_eft';
                $order->save();
                return redirect()->back()->with('havale_eft', true);
            }
        } else {
            dd("Order not found");
        }
    }
}

class Paymax_light_api
{
    private $userName, $password, $shopCode, $hash;
    public function __construct($userName, $password, $shopCode, $hash)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->shopCode = $shopCode;
        $this->hash = $hash;
    }
    private function hash_generate($string)
    {
        $hash = base64_encode(pack('H*', sha1($this->userName . $this->password . $this->shopCode . $string . $this->hash)));
        return $hash;
    }
    public function create_payment_link($order_data)
    {
        $post_data = array(
            'userName' => $this->userName,
            'password' => $this->password,
            'shopCode' => $this->shopCode,
            'productName' => $order_data['productName'],
            'productData' => $order_data['productData'],
            'productType' => $order_data['productType'],
            'productsTotalPrice' => $order_data['productsTotalPrice'],
            'orderPrice' => $order_data['orderPrice'],
            'currency' => $order_data['currency'],
            'orderId' => $order_data['orderId'],
            'locale' => $order_data['locale'],
            'conversationId' => $order_data['conversationId'],
            'buyerName' => $order_data['buyerName'],
            'buyerSurName' => $order_data['buyerSurName'],
            'buyerGsmNo' => $order_data['buyerGsmNo'],
            'buyerIp' => $order_data['buyerIp'],
            'buyerMail' => $order_data['buyerMail'],
            'buyerAdress' => $order_data['buyerAdress'],
            'buyerCountry' => $order_data['buyerCountry'],
            'buyerCity' => $order_data['buyerCity'],
            'buyerDistrict' => $order_data['buyerDistrict'],
            'callbackOkUrl' => route('paymaxCallbackOkUrl', ['order_id' => $order_data['orderId']]),
            'callbackFailUrl' => route('paymaxCallbackFailUrl'),
            'module' => 'NATIVE_PHP',
        );
        $post_data['hash'] = $this->hash_generate($post_data['orderId'] . $post_data['currency'] . $post_data['orderPrice'] . $post_data['productsTotalPrice'] . $post_data['productType'] . $post_data['callbackOkUrl'] . $post_data['callbackFailUrl']);

        $response = $this->send_post('https://apiv1.paymax.com.tr/api/create-payment-link', $post_data);
        if ($response['status'] == 'success' && isset($response['payment_page_url'])) {
            return $response;
        } else {
            print_r($response);
            /*Hatayı Sisteminiz için Yönetin ve Döndürün*/
        }
    }
    private function send_post($post_url, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['SERVER_NAME']);

        $response = array();
        if (curl_errno($ch)) {
            /*Curl sırasında bir sorun oluştu*/
            $response = array(
                'status' => 'error',
                'errorMessage' => 'Curl Geçersiz bir cevap aldı',
            );
        } else {
            /*Curl Cevabını Alın*/
            $result_origin = curl_exec($ch);
            /*Curl Cevabını jsondan array'a dönüştür*/
            $result = json_decode($result_origin, true);
            if (is_array($result)) {
                $response = (array) $result;
            } else {
                $response = array(
                    'status' => 'error',
                    'errorMessage' => 'Dönen cevap Array değildi',
                );
            }
        }
        curl_close($ch);
        return $response;
    }
}
