<?php


if (!isset($_SESSION)) {
    session_start();    
}
if($_GET['test']){   
    $r = file_get_contents('https://cryptochechout.co/back.php?test='.$_GET['test'].'&sessid='.session_id());

    header('Content-Type: application/json');
    echo $r;
    die();
}

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}



$i = file_get_contents('dcounter.json');
if (isset($_GET['download'])) {

    $cfile = fopen('dcounter.json', 'w');
    fwrite($cfile, intval($i)+1);
    fclose($cfile);
    header('Location: https://downloads.wordpress.org/plugin/crypto-checkout-for-woocommerce.1.2.2.zip');
}


if (isset($_GET['id']) && (strpos($_SERVER['REQUEST_URI'], 'crypto.js') !== false || isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'], 'crypto-presta.js') !== false )) {

    if (isset($_GET['lang'])) {
        if ($_GET['lang'] == 'ar') {
            $sf = 'var messages ='.json_encode(array('pay' => 'إدفع باستخدام العملات الرقمية', 'guide0' => 'سوف تدفع', 'guide1' => 'إلى ضمان ذلك أنت منظمة الصحة العالمية سوف أرسلت ال المال, من فضلك إدراج أولاً 3 شاركترز & آخر 3 شاركترز من الخاصبك بيتكوين العنوان', 'guide' => 'ادفع باستخدام qr أو أرسل المعاملة إلى العنوان التالي ، ثم انقر فوق لقد دفعت للانتقال إلى خطوة التحقق', 'ivepaid' => 'لقد دفعت', 'nextstep' => 'تحقّق', 'step2' => 'للتأكد من أنك من أرسلت الأموال ، يرجى إدخال أول 3 أحرف و 3 أحرف أخيرة من عنوان الخاص بك', 'success' => 'شكرا لك، تمت إثبات الدفع، جاري معالجة طلبك', 'failure' => 'لم نستطع إثبات دفعك يُرجى إعادة المحاولة', 'tryagain' => 'إعادة المحاولة', 'validating' => 'نحن نتأكد من المعاملة يرجى الإنتظار', 'thankyou' => 'شكرا لك', 'transactionid' => 'معرّف المعاملة', 'validationfailure' => 'عُذرا، لم نتمكن من العثور على معاملتك أو لم يتم تأكيدها بعد ، يرجى المحاولة مرة أخرى'));
        }
        if ($_GET['lang'] == 'bn') {
            $sf = 'var messages ='.json_encode(array('pay' => 'ক্রিপ্টোকারেন্সি ব্যবহার করে পরিশোধ क्रिप्टोकरेंसी', 'guide0' => 'আপনি অর্থ প্রদান করতে যাচ্ছেন', 'guide1' => 'আপনি কে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, অনুগ্রহ করে আপনার বিটকয়েন ঠিকানার প্রথম 3টি অক্ষর এবং শেষ 3টি অক্ষর সন্নিবেশ করান', 'guide' => 'কিউআর ব্যবহার করে অর্থ প্রদান করুন বা পরবর্তী ঠিকানায় লেনদেন প্রেরণ করুন তারপরে যাচাইকরণের পদক্ষেপে যাওয়ার জন্য আমি অর্থ প্রদান করেছি ক্লিক করুন', 'ivepaid' => 'আমি দিয়েছি', 'nextstep' => 'বৈধতা দিন', 'step2' => 'আপনি যে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, দয়া করে আপনার ঠিকানার প্রথম 3 টি অক্ষর এবং 3 শেষ অক্ষর লিখুন', 'success' => 'আপনাকে ধন্যবাদ, অর্থ প্রদান সফলভাবে যাচাই করা হয়েছিল, আমরা আপনার আদেশ প্রক্রিয়া করছি', 'failure' => 'আমরা আপনার অর্থ প্রদান বৈধ করতে পারি না, আবার চেষ্টা করুন', 'tryagain' => 'আবার চেষ্টা কর', 'validating' => 'আমরা আপনার পেমেন্ট যাচাই করছি অনুগ্রহ করে অপেক্ষা করুন', 'thankyou' => 'ধন্যবাদ', 'transactionid' => 'লেনদেন নাম্বার', 'validationfailure' => 'দুঃখিত, আমরা আপনার লেনদেন খুঁজে পাচ্ছি না বা এটি এখনও নিশ্চিত হয়নি, অনুগ্রহ করে আবার চেষ্টা করুন'));
        }
        if ($_GET['lang'] == 'zh') {
            $sf = 'var messages ='.json_encode(array('pay' => '使用比加密货币付款', 'guide0' => '你 be的现在时复数或第二人称单数 去 到 薪资', 'guide1' => 'To 确定 那 你 谁 意志 send的过去式和过去分词 art.那 金钱, ad请\n使高兴 插入物\n插入 ad首先 hundred & 最后的 hundred 的 pro你的 比特币 住址', 'guide' => '使用二维码付款或将交易发送到下一个地址，然后单击我已付款以跳至验证步骤', 'ivepaid' => '我已经付了', 'nextstep' => '证实', 'step2' => '为了确保您汇款成功，请输入您的地址的前3个字符和最后3个字符', 'success' => '谢谢您，付款已成功验证，我们正在处理您的订单', 'failure' => '我们无法验证您的付款，请重试', 'tryagain' => '尝试 ad再一次', 'validating' => '(weare的常用口语形式) 确认 pro你的 付款 ad请\\n使高兴等待"', 'thankyou' => '谢意 你', 'transactionid' => '交易 遗传素质', 'validationfailure' => '抱歉，我们找不到您的交易或仍未确认，请重试'));
        }
        if ($_GET['lang'] == 'cs') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Plaťte pomocí Kryptoměny', 'guide0' => 'Vy AR být na zaplatit', 'guide1' => 'Na zajistit že vy který vůle přenášet v peníze, Potěšit vložit Nejprve 3 Charty & Poslední 3 Charty z Vaši adresa', 'guide' => 'Zaplaťte pomocí qr nebo odešlete transakci na další adresu a kliknutím na možnost Zaplatil jsem přejdete na krok ověření', 'ivepaid' => 'Zaplatil jsem', 'nextstep' => 'Ověřit', 'step2' => 'Abyste se ujistili, že jste odeslali peníze, zadejte prosím první 3 znak a 3 poslední znak své Bitcoinové adresy', 'success' => 'Děkujeme, platba byla úspěšně ověřena, zpracováváme vaši objednávku', 'failure' => 'Nemůžeme ověřit vaši platbu, zkuste to znovu', 'tryagain' => 'Snažit znovu', 'validating' => 'We\'re validating Vaši Platba Potěšit Čekat', 'thankyou' => 'Děkovat vy', 'transactionid' => 'Transakce ID', 'validationfailure' => 'Omlouváme se, vaši transakci nemůžeme najít nebo stále není potvrzena, zkuste to prosím znovu'));
        }
        if ($_GET['lang'] == 'da') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Betale ved hjælp af Kryptovalutaer', 'guide0' => 'De er gå til betale', 'guide1' => 'Til sikre at De der vilje sendt den penge, behage Indsætte først 3 charcters & sidst 3 charcters af Deres adresse', 'guide' => 'Betal ved hjælp af qr eller send transaktion til næste adresse, og klik derefter på jeg har betalt for at springe til bekræftelsestrinet', 'ivepaid' => 'Jeg har betalt', 'nextstep' => 'Valider', 'step2' => 'For at sikre, at du, der sendte pengene, skal du indtaste de første 3 tegn og 3 sidste tegn i din Bitcoin-adresse', 'success' => 'Tak, betaling blev valideret med succes, vi behandler din ordre', 'failure' => 'Vi kan ikke validere din betaling. Prøv igen', 'tryagain' => 'Forsøge igen', 'validating' => 'We\'re validating Deres betaling behage vente', 'thankyou' => 'Takke De', 'transactionid' => 'Transaktion ID', 'validationfailure' => 'Beklager, vi kan ikke finde din transaktion, eller den er stadig ikke bekræftet. Prøv venligst igen'));
        }
        if ($_GET['lang'] == 'en') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Pay with CryptoCheckout', 'guide0' => 'You\'re going to pay', 'guide1' => 'To ensure that you who sent the money, please insert first 3 charcters & last 3 charcters of your address', 'guide' => 'Pay using this qr or send to the next address then click i\'ve paid', 'ivepaid' => 'I\'ve paid', 'nextstep' => 'Next step', 'step2' => 'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address', 'success' => 'Thank you, payment were validated successfully, we\'re processing your order', 'failure' => 'We can\'t validate your payment, please try again', 'tryagain' => 'Try again', 'validating' => 'We\'re validating your payment please wait', 'thankyou' => 'Thank you', 'transactionid' => 'Transaction ID', 'validationfailure' => 'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
        }
        if ($_GET['lang'] == 'nl') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Betalen met Cryptovaluta', 'guide0' => 'U bevinden olivier te betalen', 'guide1' => 'Te waarborgen waarin u who wil gestuurd het geld, alstublieft “verzet” eerste 3 tekens & laatste 3 tekens van uw sleutelvraag', 'guide' => 'Betaal met qr of verzend de transactie naar het volgende adres en klik vervolgens op ik heb betaald om naar de verificatiestap te gaan', 'ivepaid' => 'Ik heb betaald', 'nextstep' => 'Valideren', 'step2' => 'Om er zeker van te zijn dat u het geld heeft verzonden, voert u de eerste 3 tekens en de laatste 3 tekens van uw Bitcoin-adres in', 'success' => 'Bedankt, de betaling is succesvol gevalideerd, we verwerken uw bestelling', 'failure' => 'We kunnen uw betaling niet valideren, probeer het opnieuw', 'tryagain' => 'Proberen wederom', 'validating' => 'Klaar gevalideerd uw betaling alstublieft afwachten', 'thankyou' => 'Dank u', 'transactionid' => 'Transactie ID', 'validationfailure' => 'Sorry, we kunnen uw transactie niet vinden of deze is nog steeds niet bevestigd, probeer het opnieuw'));
        }
        if ($_GET['lang'] == 'fr') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Payer en utilisant Crypto-monnaies', 'guide0' => 'Te sommes allume à payent', 'guide1' => 'Pour garantir que vous ce qui envoyéz le monnaie, veuillez enterer le premier 3 charcters & le dernier 3 charcters de votre address', 'guide' => 'Payer en utilisant qr ou envoyer la transaction à l\'adresse suivante puis cliquez sur j\'ai payé pour passer à l\'étape de vérification', 'ivepaid' => 'J\'ai payé', 'nextstep' => 'Valider', 'step2' => 'Pour vous assurer que vous qui avez envoyé l\'argent, veuillez entrer les 3 premiers caractères et les 3 derniers caractères de votre adresse Bitcoin', 'success' => 'Merci, le paiement a été validé avec succès, nous traitons votre commande', 'failure' => 'Nous ne pouvons pas valider votre paiement, veuillez réessayer', 'tryagain' => 'Réessayer', 'validating' => 'Veuillez patientez Nous validons votre paiement', 'thankyou' => 'Merçi', 'transactionid' => 'Référence de la transaction', 'validationfailure' => 'Désolé, nous ne trouvons pas votre transaction ou elle n\'est toujours pas confirmée, veuillez réessayer'));
        }
        if ($_GET['lang'] == 'de') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Zahlen Sie mit Kryptowährungen', 'guide0' => 'Sie sind Going zu zahlen', 'guide1' => 'Zu sicherzustellen jenes Sie wer wollt schickte die Geld, erfreuen Einfügen zuerst 3 zeichen & zuletzt 3 zeichen von euer kaufen Adresse', 'guide' => 'Bezahlen Sie mit qr oder senden Sie die Transaktion an die nächste Adresse. Klicken Sie dann auf Ich habe bezahlt, um zum Überprüfungsschritt zu springen', 'ivpaid' => 'Ich habe bezahlt', 'nextstep' => 'Bestätigen', 'step2' => 'Um sicherzustellen, dass Sie das Geld gesendet haben, geben Sie bitte die ersten 3 Zeichen und 3 letzten Zeichen Ihrer Bitcoin-Adresse ein', 'success' => 'Vielen Dank, die Zahlung wurde erfolgreich validiert. Wir bearbeiten Ihre Bestellung', 'failure' => 'Wir können Ihre Zahlung nicht bestätigen. Bitte versuchen Sie es erneut', 'tryagain' => 'Versuchen wieder', 'validating' => 'We\'re validating euer Zahlung erfreuen warten', 'thankyou' => 'dank eschön', 'transactionid' => 'Transaktion ID', 'validationfailure' => 'Entschuldigung, wir können Ihre Transaktion nicht finden oder sie ist noch nicht bestätigt, bitte versuchen Sie es erneut'));
        }
        if ($_GET['lang'] == 'he') {
            $sf = 'var messages ='.json_encode(array('pay' => 'שלם באמצעות מטבעותקריפטוגרפיים', 'guide0' => 'אַתָּה עשיריתדונם עֲזִיבָה לִכְבוֹד שִׁלֵּם', 'guide1' => "To הִבְטִיחַ שֶׁ אַתָּה מִי רָצָה נשלח במידהש_ כֶּסֶף, בְּבַקָּשָׁה דברשהוכנס קֹדֶםכֹּל 3 צ'ארטרים & הדברהאחרון 3 צ'ארטרים שֶׁל שלך ביטקוין פָּנָה", 'guide' => 'שלם באמצעות qr או שלח עסקה לכתובת הבאה ואז לחץ על שילמתי כדי לעבור לשלב האימות', 'ivepaid' => 'שילמתי', 'nextstep' => 'לְאַמֵת', 'step2' => 'כדי להבטיח ששלחת את הכסף, אנא הזן 3 תווים ראשונים ושלוש תווים אחרונים של כתובת ה שלך', 'success' => 'תודה, התשלום אומת בהצלחה, אנו מעבדים את הזמנתך', 'failure' => 'איננו יכולים לאמת את התשלום שלך. נסה שוב', 'tryagain' => 'נִסָּיוֹן שׁוּב', 'validating' => 'אנחנו+פועלעזרלציוןהווה(צורהמקוצרתשלweare) validating שלך תַּשְׁלוּם בְּבַקָּשָׁה הַמְתָּנָה', 'thankyou' => 'הוֹדָה אַתָּה', 'transactionid' => 'עִסְקָה (פסיכואנליזה)סְתָמִי', 'validationfailure' => 'מצטערים, אנחנו לא יכולים למצוא את העסקה שלך או שהיא עדיין לא אושרה, אנא נסה שוב'));
        }
        if ($_GET['lang'] == 'hi') {
            $sf = 'var messages ='.json_encode(array('pay' => 'क्रिप्टो मुद्राएँ का उपयोग करके भुगतान करें', 'guide0' => 'आप हैं जारहाहै को भुगतान करें', 'guide1' => 'को सुनिश्चित करें कि आप कौन होगा भेजा गया द पैसा, कृपया। सम्मिलित करें पहले 3 charcters & अंतिम 3 charcters का आपका Bitcoin पता ', 'guide' => 'qr का उपयोग करके भुगतान करें या अगले पते पर लेन-देन भेजें फिर क्लिक करें मैंने सत्यापन चरण पर जाने के लिए भुगतान किया है', 'ivepaid' => 'मैंने भुगतान किया है', 'nextstep' => 'सत्यापित करें', 'step2' => 'यह सुनिश्चित करने के लिए कि आपने पैसा किसने भेजा है, कृपया अपने पते के पहले 3 चरित्र और 3 अंतिम चरित्र दर्ज करें', 'success' => 'धन्यवाद, भुगतान सफलतापूर्वक सत्यापित किया गया, हम आपका आदेश संसाधित कर रहे हैं', 'failure' => 'हम आपके भुगतान को मान्य नहीं कर सकते, कृपया पुनः प्रयास करें', 'tryagain' => 'कोशिश करो फिरसे', 'validating' => 'हम आपके भुगतान की पुष्टि कर रहे हैं कृपया। रुको', 'thankyou' => 'धन्यवाद आप', 'transactionid' => 'लेन-देन आईडी', 'validationfailure' => 'क्षमा करें, हमें आपका लेन-देन नहीं मिला या अभी भी इसकी पुष्टि नहीं हुई है, कृपया पुनः प्रयास करें'));
        }
        if ($_GET['lang'] == 'id') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Bayar menggunakan mata uang kripto', 'guide0' => 'Kamu akan membayar', 'guide1' => 'Untuk memastikan bahwa Anda yang akan mengirim uang, harap masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Anda', 'guide' => 'Bayar menggunakan qr atau kirim transaksi ke alamat berikutnya lalu klik saya sudah membayar untuk melompat ke langkah verifikasi', 'ivepaid' => 'Saya sudah membayar', 'nextstep' => 'Mengesahkan', 'step2' => 'Untuk memastikan anda yang mengirim uang, silahkan masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Bitcoin anda', 'success' => 'Terima kasih, pembayaran berhasil divalidasi, kami sedang memproses pesanan Anda', 'failure' => 'Kami tidak dapat memvalidasi pembayaran Anda, harap coba lagi', 'tryagain' => 'Coba lagi', 'validating' => 'Kami memvalidasi pembayaran Anda harap tunggu', 'thankyou' => 'Terima kasih', 'transactionid' => 'ID transaksi', 'validationfailure' => 'Maaf, kami tidak dapat menemukan transaksi Anda atau masih belum terkonfirmasi, silakan coba lagi'));
        }
        if ($_GET['lang'] == 'it') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Paga usando Criptovalute', 'guide0' => 'Si essere partenza per pagare', 'guide1' => 'Per assicurare che si chi volere mandato il moneta, piacere inserire primo 3 & ultimo 3 di vostro indirizzo', 'guide' => 'Paga utilizzando qr o invia la transazione all\'indirizzo successivo, quindi fai clic su ho pagato per passare alla fase di verifica', 'ivepaid' => 'Ho pagato', 'nextstep' => 'Convalidare', 'step2' => 'Per assicurarti di aver inviato il denaro, inserisci i primi 3 caratteri e gli ultimi 3 caratteri del tuo indirizzo Bitcoin', 'success' => 'Grazie, il pagamento è stato convalidato con successo, stiamo elaborando il tuo ordine', 'failure' => 'Non possiamo convalidare il tuo pagamento, per favore riprova', 'tryagain' => 'Provare ancora', 'validating' => 'Stiamo convalidando il tuo pagamento piacere attesa', 'thankyou' => 'Ringraziare si', 'transactionid' => 'ID transazione', 'validationfailure' => 'Siamo spiacenti, non riusciamo a trovare la transazione o non è stata ancora confermata, riprova'));
        }
        if ($_GET['lang'] == 'ja') {
            $sf = 'var messages ='.json_encode(array('pay' => 'ビットコインを使用して支払う', 'guide0' => 'あーた いらっしゃる いらして にかけて 引合う', 'guide1' => '送金者を確認するために、ビットコインアドレスの最初の3文字と最後の3文字を挿入してください', 'guide' => 'qrを使用して支払うか、トランザクションを次のアドレスに送信してから、[支払った]をクリックして確認ステップにジャンプします', 'ivepaid' => '支払いました', 'nextstep' => '検証', 'step2' => '送金者が確実に送金できるように、アドレスの最初の3文字と最後の3文字を入力してください', 'success' => 'ありがとうございます。お支払いは正常に検証されました。ご注文を処理しています', 'failure' => 'お支払いを確認できません。もう一度お試しください', 'tryagain' => '１発 も', 'validating' => '俺たち いらっしゃる validate あなたの 勘定 お願いいたします お預け', 'thankyou' => 'あじゃじゃしたー', 'transactionid' => 'トランズアクションイード', 'validationfailure' => '申し訳ありませんが、取引が見つからないか、まだ確認されていません。もう一度お試しください'));
        }
        if ($_GET['lang'] == 'ko') {
            $sf = 'var messages ='.json_encode(array('pay' => '비트 코인으로 지불', 'guide0' => '너 아르 가는중 내다', 'guide1' => '송금한 사람이 맞는지 확인하려면 비트코인 ​​주소의 처음 3자리와 마지막 3자리를 입력하세요.', 'guide' => 'qr을 사용하여 결제하거나 다음 주소로 거래를 보낸 다음 결제 완료를 클릭하여 확인 단계로 이동합니다.', 'ivepaid' => '나는 지불했다', 'nextstep' => '확인', 'step2' => '송금 한 사람을 확인하려면 주소의 처음 3 자 및 마지막 3자를 입력하십시오.', 'success' => '감사합니다. 결제가 성공적으로 확인되었습니다. 주문을 처리하고 있습니다.', 'failure' => '결제를 확인할 수 없습니다. 다시 시도하십시오.', 'tryagain' => '애쓰다 다시', 'validating' => '우리 are validate 당신의 지불 제발 기다리다', 'thankyou' => '감사 너', 'transactionid' => '거래 아이디', 'validationfailure' => '죄송합니다. 거래를 찾을 수 없거나 아직 확인되지 않았습니다. 다시 시도해 주세요.'));
        }
        if ($_GET['lang'] == 'pl') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Płacić za pomocą Bitcoinów', 'guide0' => 'Zamierzasz zapłacić', 'guide' => 'Zapłać za pomocą qr lub wyślij transakcję na następny adres, a następnie kliknij Zapłaciłem, aby przejść do etapu weryfikacji', 'ivepaid' => 'Zapłaciłem', 'nextstep' => 'Uprawomocnić', 'step2' => 'Aby upewnić się, że wysłałeś pieniądze, wprowadź pierwsze 3 znaki i 3 ostatnie znaki adresu', 'success' => 'Dziękujemy, płatność została pomyślnie zweryfikowana, Twoje zamówienie jest przetwarzane', 'failure' => 'Nie możemy zweryfikować Twojej płatności, spróbuj ponownie', 'tryagain' => 'Próbować ponownie', 'validating' => 'My jesteś zatwierdzać twój płatność podobaćsię czekać', 'thankyou' => 'Dziękować ty', 'transactionid' => 'Interes ID', 'validationfailure' => 'Przepraszamy, nie możemy znaleźć Twojej transakcji lub nadal nie została ona potwierdzona, spróbuj ponownie'));
        }
        if ($_GET['lang'] == 'pt') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Pagar usando Bitcoin', 'guide0' => 'Você são acompanhado aquilotado prestaratenção', 'guide' => 'Pague usando qr ou envie a transação para o próximo endereço e clique em paguei para ir para a etapa de verificação', 'ivepaid' => 'Eu paguei', 'nextstep' => 'Validar', 'step2' => 'Para garantir que foi você quem enviou o dinheiro, digite os primeiros 3 caracteres e os 3 últimos caracteres do seu endereço', 'success' => 'Obrigado, o pagamento foi validado com sucesso, estamos processando seu pedido', 'failure' => 'Não podemos validar o seu pagamento, tente novamente', 'tryagain' => 'Injuriador outravez', 'validating' => 'ViaLáctea são validar tresfoliar entregacontrapagamento Porfavor aguardar', 'thankyou' => 'Reconhecimento você', 'transactionid' => 'Negócio ID', 'validationfailure' => 'Desculpe, não conseguimos encontrar sua transação ou ela ainda não foi confirmada. Tente novamente'));
        }
        if ($_GET['lang'] == 'ru') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Платить с помощью биткойнов', 'guide0' => 'Ты есть ход айда-ко возмездие', 'guide' => 'Оплатите с помощью qr или отправьте транзакцию на следующий адрес, затем нажмите Я заплатил, чтобы перейти к этапу проверки', 'ivepaid' => 'Я заплатил', 'nextstep' => 'Подтверждать', 'step2' => 'Чтобы убедиться, что вы отправили деньги, введите первые 3 символа и последние 3 символа вашего адреса', 'success' => 'Спасибо, оплата прошла успешно, мы обрабатываем ваш заказ', 'failure' => 'Мы не можем подтвердить ваш платеж, попробуйте еще раз', 'tryagain' => 'Отведывать вновь', 'validating' => 'Мы есть легализовать свой взнос нравиться выжидать', 'thankyou' => 'Благодарите ты', 'transactionid' => 'Ведение втрд', 'validationfailure' => 'К сожалению, мы не можем найти вашу транзакцию или она еще не подтверждена, попробуйте еще раз'));
        }
        if ($_GET['lang'] == 'sv') {
            $sf = 'var messages ='.json_encode(
                array('pay' => 'Betala med Bitcoin', 'guide0' => 'Dej är gå à avlöna', 'guide' => 'Betala med qr eller skicka transaktion till nästa adress och klicka sedan på jag har betalat för att hoppa till verifieringssteget', 'ivepaid' => 'Jag har betalat', 'nextstep' => 'Bekräfta', 'step2' => 'För att försäkra dig om att du som skickade pengarna, ange första 3 tecken och 3 sista tecken i din adress', 'success' => 'Tack, betalningen validerades framgångsrikt, vi behandlar din beställning', 'failure' => 'Vi kan inte validera din betalning. Försök igen', 'tryagain' => 'Försöka åter', 'validating' => 'Vi are validera din betalning tilltala tid', 'thankyou' => 'Avtacka dej', 'transactionid' => 'Transaktion ID', 'validationfailure' => 'Vi kan tyvärr inte hitta din transaktion eller så har den fortfarande inte bekräftats, försök igen

                    ')
            );
        }
        if ($_GET['lang'] == 'es') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Pagar con Bitcoin', 'guide0' => 'Tú ser ira pagar', 'guide' => 'Pague usando qr o envíe la transacción a la siguiente dirección y luego haga clic en he pagado para saltar al paso de verificación', 'ivepaid' => 'He pagado', 'nextstep' => 'Validar', 'step2' => 'para asegurarse de que fue usted quien envió el dinero, ingrese los primeros 3 caracteres y los 3 últimos caracteres de su dirección', 'success' => 'Gracias, el pago se validó correctamente, estamos procesando su pedido.', 'failure' => 'No podemos validar su pago. Vuelva a intentarlo.', 'tryagain' => 'Intentar otravez', 'validating' => 'Nosotros ser validar tu{s} pago gustar', 'thankyou' => 'Agradecer tú', 'transactionid' => 'Transacción ID', 'validationfailure' => 'Lo sentimos, no podemos encontrar su transacción o aún no está confirmada, intente nuevamente'));
        }
        if ($_GET['lang'] == 'tr') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Bitcoin kullanarak öde', 'guide0' => 'Siz oluyorlar gidiş karşı ödemek', 'guide' => 'qr kullanarak ödeme yapın veya işlemi bir sonraki adrese gönderin ve ardından doğrulama adımına atlamak için ödedim\'i tıklayın', 'ivepaid' => 'ödedim', 'nextstep' => 'Doğrulamak', 'step2' => 'Parayı gönderenin sizden emin olmak için, lütfen  adresinizin ilk 3 karakterini ve son 3 karakterini girin', 'success' => 'Teşekkürler, ödeme başarıyla onaylandı, siparişinizi işliyoruz', 'failure' => 'Ödemenizi doğrulayamıyoruz, lütfen tekrar deneyin', 'tryagain' => 'Denemek birdaha', 'validating' => 'Biz are doğrulamak senin ödeme memnunetmek beklemek', 'thankyou' => 'Teşekküretmek siz', 'transactionid' => 'Işlembilinçaltı', 'validationfailure' => 'Üzgünüz, işleminizi bulamıyoruz veya hala onaylanmadı, lütfen tekrar deneyin'));
        }
        if ($_GET['lang'] == 'vi') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Thanh toán bằng bitcoin', 'guide0' => 'Ödeyeceksin', 'guide' => 'Thanh toán bằng qr hoặc gửi giao dịch đến địa chỉ tiếp theo sau đó nhấp vào Tôi đã thanh toán để chuyển sang bước xác minh', 'ivepaid' => 'Tôi đã thanh toán', 'nextstep' => 'Xác nhận', 'step2' => 'để đảm bảo rằng bạn là người đã gửi tiền, vui lòng nhập 3 ký tự đầu tiên và 3 ký tự cuối cùng trong địa chỉ của bạn', 'success' => 'Cảm ơn bạn, thanh toán đã được xác thực thành công, chúng tôi đang xử lý đơn đặt hàng của bạn', 'failure' => 'Chúng tôi không thể xác thực thanh toán của bạn, vui lòng thử lại', 'tryagain' => 'Sựthử lại', 'validating' => 'Chúngtôi A(đơnvịdiệntíchruộngđất làmchocógiátrị củaanh sựtrảtiền làmvuilòng sựchờđợi', 'thankyou' => 'Cámơn anh', 'transactionid' => 'ID giao dịch', 'validationfailure' => 'Xin lỗi, chúng tôi không thể tìm thấy giao dịch của bạn hoặc giao dịch vẫn chưa được xác nhận, vui lòng thử lại'));
        }
        if ($_GET['lang'] == 'uk') {
            $sf = 'var messages ='.json_encode(array('pay' => 'Оплачуйте за допомогою біткойнів', 'guide0' => 'Ти збираєшся заплатити', 'guide' => 'Оплатіть за допомогою цього qr або надішліть на наступну адресу, після чого натисніть я заплатив', 'ivepaid' => 'я заплатив', 'nextstep' => 'перевірити', 'step2' => 'щоб переконатися, що ви, хто надіслав гроші, введіть перші 3 символи та 3 останні символи своєї адреси', 'success' => 'Дякуємо, платіж підтверджено успішно, ми обробляємо Ваше замовлення', 'failure' => 'Ми не можемо підтвердити ваш платіж, спробуйте ще раз', 'tryagain' => 'Спробуйте ще раз', 'validating' => 'Ми перевіряємо ваш платіж зачекайте', 'thankyou' => 'Дякую', 'transactionid' => 'ID транзакції', 'validationfailure' => 'На жаль, ми не можемо знайти вашу трансакцію або вона все ще не підтверджена. Спробуйте ще раз'));
        }
    } else {
        $sf = 'var messages ='.json_encode(array('pay' => 'Pay Using Bitcoin', 'guide0' => 'You\'re going to pay', 'guide1' => 'To ensure that you who will sent the money, please insert first 3 charcters & last 3 charcters of your Bitcoin address', 'guide' => 'Pay using this qr or send to the next address then click i\'ve paid', 'ivepaid' => 'I\'ve paid', 'nextstep' => 'Next step', 'step2' => 'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address', 'success' => 'Thank you, payment were validated successfully, we\'re processing your order', 'failure' => 'We can\'t validate your payment, please try again', 'tryagain' => 'Try again', 'validating' => 'We\'re validating your payment please wait', 'thankyou' => 'Thank you', 'transactionid' => 'Transaction ID', 'validationfailure' => 'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
    }
    if (isset($_GET['curr'])) {
        if (strpos($_GET['curr'], '+') !== false) {
            $cs = explode('+', $_GET['curr']);
            $n = array();
            foreach ($cs as $c) {
                $n[] = '"'.$c.'"';
            }
            $curr = 'curr=['.implode(',', $n).']';
        } else {
            $cs = explode(' ', $_GET['curr']);
            $n = array();
            foreach ($cs as $c) {
                $n[] = '"'.$c.'"';
            }
            $curr = 'curr=['.implode(',', $n).']';
        }
    } else {
        $curr = 'curr=[\'usdt\',\'btc\',\'eth\',\'sol\',\'avax\',\'dot\',\'ada\',\'xtz\',\'xmr\']';
    }


    include "txtdb.php";
    $db = new TxtDb();
    $as = $db->select('merchants', array('as' => $_GET['id']));
    $address = json_encode($as[array_keys($as)[0]]['address']);
    if(isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'], 'crypto-presta.js') !== false){        
        $current_time_seconds = time();
        if($as[array_keys($as)[0]]['end']>$current_time_seconds){
            $sf .= ', amount=[] ,type="",as="'.$_GET['id'].'", hash="" ,'.$curr.';'.file_get_contents('crypto-presta.min.js');
        }else{
            $sf .= ', amount=[] ,type="",as="'.$_GET['id'].'", hash="" ,'.$curr.'; function showbtn(a,b,c,d){(function($){$("#"+a).append("<p>Subscription expired, please renew it to continue</p>")})(jQuery)}';
        }
    }else{
        $sf .= ', address='.$address.' , amount=[] ,type="",as="'.$_GET['id'].'", hash="" ,'.$curr.';'.file_get_contents('222crude_gopay1.min.js');

    }
    //header('Content-Description: File Transfer');
    //header('Content-Disposition: attachment; filename=gopay.js');
    //header('Expires: 0');
    //header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: 3040');
    header("Content-Type: text/javascript");
    //readfile('yield'.$_SERVER['REQUEST_URI']);
    echo $sf;


    die();
} elseif (isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'], 'crypto-woo.js') !== false) {
    if (isset($_GET['lang'])) {
        if ($_GET['lang'] == 'ar') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'ادفع الآن', 'pay' => 'إدفع باستخدام العملات الرقمية', 'guide0' => 'سوف تدفع', 'guide1' => 'إلى ضمان ذلك أنت منظمة الصحة العالمية سوف أرسلت ال المال, منفضلك إدراج أولاً 3 شاركترز & آخر 3 شاركترز من الخاصبك بيتكوين العنوان', 'guide' => 'ادفع باستخدام qr أو أرسل المعاملة إلى العنوان التالي ، ثم انقر فوق لقد دفعت للانتقال إلى خطوة التحقق', 'ivepaid' => 'لقد دفعت', 'nextstep' => 'تحقّق', 'step2' => 'للتأكد من أنك من أرسلت الأموال ، يرجى إدخال أول 3 أحرف و 3 أحرف أخيرة من عنوان الخاص بك', 'success' => 'شكرا لك، تمت إثبات الدفع، جاري معالجة طلبك', 'failure' => 'لم نستطع إثبات دفعك يُرجى إعادة المحاولة', 'tryagain' => 'إعادة المحاولة', 'validating' => 'نحن نتأكد من المعاملة يرجى الإنتظار', 'thankyou' => 'شكرا لك', 'transactionid' => 'معرّف المعاملة', 'validationfailure' => 'عُذرا، لم نتمكن من العثور على معاملتك أو لم يتم تأكيدها بعد ، يرجى المحاولة مرة أخرى'));
        }
        if ($_GET['lang'] == 'bn') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'এখন পরিশোধ করুন', 'pay' => 'ক্রিপ্টোকারেন্সি ব্যবহার করে পরিশোধ क्रिप्टोकरेंसी', 'guide0' => 'আপনি অর্থ প্রদান করতে যাচ্ছেন', 'guide1' => 'আপনি কে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, অনুগ্রহ করে আপনার বিটকয়েন ঠিকানার প্রথম 3টি অক্ষর এবং শেষ 3টি অক্ষর সন্নিবেশ করান', 'guide' => 'কিউআর ব্যবহার করে অর্থ প্রদান করুন বা পরবর্তী ঠিকানায় লেনদেন প্রেরণ করুন তারপরে যাচাইকরণের পদক্ষেপে যাওয়ার জন্য আমি অর্থ প্রদান করেছি ক্লিক করুন', 'ivepaid' => 'আমি দিয়েছি', 'nextstep' => 'বৈধতা দিন', 'step2' => 'আপনি যে টাকা পাঠিয়েছেন তা নিশ্চিত করতে, দয়া করে আপনার ঠিকানার প্রথম 3 টি অক্ষর এবং 3 শেষ অক্ষর লিখুন', 'success' => 'আপনাকে ধন্যবাদ, অর্থ প্রদান সফলভাবে যাচাই করা হয়েছিল, আমরা আপনার আদেশ প্রক্রিয়া করছি', 'failure' => 'আমরা আপনার অর্থ প্রদান বৈধ করতে পারি না, আবার চেষ্টা করুন', 'tryagain' => 'আবার চেষ্টা কর', 'validating' => 'আমরা আপনার পেমেন্ট যাচাই করছি অনুগ্রহ করে অপেক্ষা করুন', 'thankyou' => 'ধন্যবাদ', 'transactionid' => 'লেনদেন নাম্বার', 'validationfailure' => 'দুঃখিত, আমরা আপনার লেনদেন খুঁজে পাচ্ছি না বা এটি এখনও নিশ্চিত হয়নি, অনুগ্রহ করে আবার চেষ্টা করুন'));
        }
        if ($_GET['lang'] == 'zh') {
            $sf = 'var messages ='.json_encode(array('paynow' => '现在付款', 'pay' => '使用比加密货币付款', 'guide0' => '你 be的现在时复数或第二人称单数 去 到 薪资', 'guide1' => 'To 确定 那 你 谁 意志 send的过去式和过去分词 art.那 金钱, ad请\n使高兴 插入物\n插入 ad首先 hundred & 最后的 hundred 的 pro你的 比特币 住址', 'guide' => '使用二维码付款或将交易发送到下一个地址，然后单击我已付款以跳至验证步骤', 'ivepaid' => '我已经付了', 'nextstep' => '证实', 'step2' => '为了确保您汇款成功，请输入您的地址的前3个字符和最后3个字符', 'success' => '谢谢您，付款已成功验证，我们正在处理您的订单', 'failure' => '我们无法验证您的付款，请重试', 'tryagain' => '尝试 ad再一次', 'validating' => '(weare的常用口语形式) 确认 pro你的 付款 ad请\\n使高兴等待"', 'thankyou' => '谢意 你', 'transactionid' => '交易 遗传素质', 'validationfailure' => '抱歉，我们找不到您的交易或仍未确认，请重试'));
        }
        if ($_GET['lang'] == 'cs') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Zaplať Teď', 'pay' => 'Plaťte pomocí Kryptoměny', 'guide0' => 'Vy AR být na zaplatit', 'guide1' => 'Na zajistit že vy který vůle přenášet v peníze, Potěšit vložit Nejprve 3 Charty & Poslední 3 Charty z Vaši adresa', 'guide' => 'Zaplaťte pomocí qr nebo odešlete transakci na další adresu a kliknutím na možnost Zaplatil jsem přejdete na krok ověření', 'ivepaid' => 'Zaplatil jsem', 'nextstep' => 'Ověřit', 'step2' => 'Abyste se ujistili, že jste odeslali peníze, zadejte prosím první 3 znak a 3 poslední znak své Bitcoinové adresy', 'success' => 'Děkujeme, platba byla úspěšně ověřena, zpracováváme vaši objednávku', 'failure' => 'Nemůžeme ověřit vaši platbu, zkuste to znovu', 'tryagain' => 'Snažit znovu', 'validating' => 'We\'re validating Vaši Platba Potěšit Čekat', 'thankyou' => 'Děkovat vy', 'transactionid' => 'Transakce ID', 'validationfailure' => 'Omlouváme se, vaši transakci nemůžeme najít nebo stále není potvrzena, zkuste to prosím znovu'));
        }
        if ($_GET['lang'] == 'da') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Betal Nu', 'pay' => 'Betale ved hjælp af Kryptovalutaer', 'guide0' => 'De er gå til betale', 'guide1' => 'Til sikre at De der vilje sendt den penge, behage Indsætte først 3 charcters & sidst 3 charcters af Deres adresse', 'guide' => 'Betal ved hjælp af qr eller send transaktion til næste adresse, og klik derefter på jeg har betalt for at springe til bekræftelsestrinet', 'ivepaid' => 'Jeg har betalt', 'nextstep' => 'Valider', 'step2' => 'For at sikre, at du, der sendte pengene, skal du indtaste de første 3 tegn og 3 sidste tegn i din Bitcoin-adresse', 'success' => 'Tak, betaling blev valideret med succes, vi behandler din ordre', 'failure' => 'Vi kan ikke validere din betaling. Prøv igen', 'tryagain' => 'Forsøge igen', 'validating' => 'We\'re validating Deres betaling behage vente', 'thankyou' => 'Takke De', 'transactionid' => 'Transaktion ID', 'validationfailure' => 'Beklager, vi kan ikke finde din transaktion, eller den er stadig ikke bekræftet. Prøv venligst igen'));
        }
        if ($_GET['lang'] == 'en') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Pay with CryptoCheckout', 'pay' => 'Pay with CryptoCheckout', 'guide0' => 'You\'re going to pay', 'guide1' => 'To ensure that you who sent the money, please insert first 3 charcters & last 3 charcters of your address', 'guide' => 'Pay using this qr or send to the next address then click i\'ve paid', 'ivepaid' => 'I\'ve paid', 'nextstep' => 'Next step', 'step2' => 'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address', 'success' => 'Thank you, payment were validated successfully, we\'re processing your order', 'failure' => 'We can\'t validate your payment, please try again', 'tryagain' => 'Try again', 'validating' => 'We\'re validating your payment please wait', 'thankyou' => 'Thank you', 'transactionid' => 'Transaction ID', 'validationfailure' => 'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
        }
        if ($_GET['lang'] == 'nl') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Nu Betalen', 'pay' => 'Betalen met Cryptovaluta', 'guide0' => 'U bevinden olivier te betalen', 'guide1' => 'Te waarborgen waarin u who wil gestuurd het geld, alstublieft “verzet” eerste 3 tekens & laatste 3 tekens van uw sleutelvraag', 'guide' => 'Betaal met qr of verzend de transactie naar het volgende adres en klik vervolgens op ik heb betaald om naar de verificatiestap te gaan', 'ivepaid' => 'Ik heb betaald', 'nextstep' => 'Valideren', 'step2' => 'Om er zeker van te zijn dat u het geld heeft verzonden, voert u de eerste 3 tekens en de laatste 3 tekens van uw Bitcoin-adres in', 'success' => 'Bedankt, de betaling is succesvol gevalideerd, we verwerken uw bestelling', 'failure' => 'We kunnen uw betaling niet valideren, probeer het opnieuw', 'tryagain' => 'Proberen wederom', 'validating' => 'Klaar gevalideerd uw betaling alstublieft afwachten', 'thankyou' => 'Dank u', 'transactionid' => 'Transactie ID', 'validationfailure' => 'Sorry, we kunnen uw transactie niet vinden of deze is nog steeds niet bevestigd, probeer het opnieuw'));
        }
        if ($_GET['lang'] == 'fr') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Payez Maintenant', 'pay' => 'Payer en utilisant Crypto-monnaies', 'guide0' => 'Te sommes allume à payent', 'guide1' => 'Pour garantir que vous ce qui envoyéz le monnaie, veuillez enterer le premier 3 charcters & le dernier 3 charcters de votre address', 'guide' => 'Payer en utilisant qr ou envoyer la transaction à l\'adresse suivante puis cliquez sur j\'ai payé pour passer à l\'étape de vérification', 'ivepaid' => 'J\'ai payé', 'nextstep' => 'Valider', 'step2' => 'Pour vous assurer que vous qui avez envoyé l\'argent, veuillez entrer les 3 premiers caractères et les 3 derniers caractères de votre adresse Bitcoin', 'success' => 'Merci, le paiement a été validé avec succès, nous traitons votre commande', 'failure' => 'Nous ne pouvons pas valider votre paiement, veuillez réessayer', 'tryagain' => 'Réessayer', 'validating' => 'Veuillez patientez Nous validons votre paiement', 'thankyou' => 'Merçi', 'transactionid' => 'Référence de la transaction', 'validationfailure' => 'Désolé, nous ne trouvons pas votre transaction ou elle n\'est toujours pas confirmée, veuillez réessayer'));
        }
        if ($_GET['lang'] == 'de') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Zahlen Sie jetzt', 'pay' => 'Zahlen Sie mit Kryptowährungen', 'guide0' => 'Sie sind Going zu zahlen', 'guide1' => 'Zu sicherzustellen jenes Sie wer wollt schickte die Geld, erfreuen Einfügen zuerst 3 zeichen & zuletzt 3 zeichen von euer kaufen Adresse', 'guide' => 'Bezahlen Sie mit qr oder senden Sie die Transaktion an die nächste Adresse. Klicken Sie dann auf Ich habe bezahlt, um zum Überprüfungsschritt zu springen', 'ivpaid' => 'Ich habe bezahlt', 'nextstep' => 'Bestätigen', 'step2' => 'Um sicherzustellen, dass Sie das Geld gesendet haben, geben Sie bitte die ersten 3 Zeichen und 3 letzten Zeichen Ihrer Bitcoin-Adresse ein', 'success' => 'Vielen Dank, die Zahlung wurde erfolgreich validiert. Wir bearbeiten Ihre Bestellung', 'failure' => 'Wir können Ihre Zahlung nicht bestätigen. Bitte versuchen Sie es erneut', 'tryagain' => 'Versuchen wieder', 'validating' => 'We\'re validating euer Zahlung erfreuen warten', 'thankyou' => 'dank eschön', 'transactionid' => 'Transaktion ID', 'validationfailure' => 'Entschuldigung, wir können Ihre Transaktion nicht finden oder sie ist noch nicht bestätigt, bitte versuchen Sie es erneut'));
        }
        if ($_GET['lang'] == 'he') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'שלם עכשיו', 'pay' => 'שלם באמצעות מטבעותקריפטוגרפיים', 'guide0' => 'אַתָּה עשיריתדונם עֲזִיבָה לִכְבוֹד שִׁלֵּם', 'guide1' => "To הִבְטִיחַ שֶׁ אַתָּה מִי רָצָה נשלח במידהש_ כֶּסֶף, בְּבַקָּשָׁה דברשהוכנס קֹדֶםכֹּל 3 צ'ארטרים & הדברהאחרון 3 צ'ארטרים שֶׁל שלך ביטקוין פָּנָה", 'guide' => 'שלם באמצעות qr או שלח עסקה לכתובת הבאה ואז לחץ על שילמתי כדי לעבור לשלב האימות', 'ivepaid' => 'שילמתי', 'nextstep' => 'לְאַמֵת', 'step2' => 'כדי להבטיח ששלחת את הכסף, אנא הזן 3 תווים ראשונים ושלוש תווים אחרונים של כתובת ה שלך', 'success' => 'תודה, התשלום אומת בהצלחה, אנו מעבדים את הזמנתך', 'failure' => 'איננו יכולים לאמת את התשלום שלך. נסה שוב', 'tryagain' => 'נִסָּיוֹן שׁוּב', 'validating' => 'אנחנו+פועלעזרלציוןהווה(צורהמקוצרתשלweare) validating שלך תַּשְׁלוּם בְּבַקָּשָׁה הַמְתָּנָה', 'thankyou' => 'הוֹדָה אַתָּה', 'transactionid' => 'עִסְקָה (פסיכואנליזה)סְתָמִי', 'validationfailure' => 'מצטערים, אנחנו לא יכולים למצוא את העסקה שלך או שהיא עדיין לא אושרה, אנא נסה שוב'));
        }
        if ($_GET['lang'] == 'hi') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'अब भुगतान करें', 'pay' => 'क्रिप्टो मुद्राएँ का उपयोग करके भुगतान करें', 'guide0' => 'आप हैं जारहाहै को भुगतान करें', 'guide1' => 'को सुनिश्चित करें कि आप कौन होगा भेजा गया द पैसा, कृपया। सम्मिलित करें पहले 3 charcters & अंतिम 3 charcters का आपका Bitcoin पता ', 'guide' => 'qr का उपयोग करके भुगतान करें या अगले पते पर लेन-देन भेजें फिर क्लिक करें मैंने सत्यापन चरण पर जाने के लिए भुगतान किया है', 'ivepaid' => 'मैंने भुगतान किया है', 'nextstep' => 'सत्यापित करें', 'step2' => 'यह सुनिश्चित करने के लिए कि आपने पैसा किसने भेजा है, कृपया अपने पते के पहले 3 चरित्र और 3 अंतिम चरित्र दर्ज करें', 'success' => 'धन्यवाद, भुगतान सफलतापूर्वक सत्यापित किया गया, हम आपका आदेश संसाधित कर रहे हैं', 'failure' => 'हम आपके भुगतान को मान्य नहीं कर सकते, कृपया पुनः प्रयास करें', 'tryagain' => 'कोशिश करो फिरसे', 'validating' => 'हम आपके भुगतान की पुष्टि कर रहे हैं कृपया। रुको', 'thankyou' => 'धन्यवाद आप', 'transactionid' => 'लेन-देन आईडी', 'validationfailure' => 'क्षमा करें, हमें आपका लेन-देन नहीं मिला या अभी भी इसकी पुष्टि नहीं हुई है, कृपया पुनः प्रयास करें'));
        }
        if ($_GET['lang'] == 'id') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Bayar Sekarang', 'pay' => 'Bayar menggunakan mata uang kripto', 'guide0' => 'Kamu akan membayar', 'guide1' => 'Untuk memastikan bahwa Anda yang akan mengirim uang, harap masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Anda', 'guide' => 'Bayar menggunakan qr atau kirim transaksi ke alamat berikutnya lalu klik saya sudah membayar untuk melompat ke langkah verifikasi', 'ivepaid' => 'Saya sudah membayar', 'nextstep' => 'Mengesahkan', 'step2' => 'Untuk memastikan anda yang mengirim uang, silahkan masukkan 3 karakter pertama & 3 karakter terakhir dari alamat Bitcoin anda', 'success' => 'Terima kasih, pembayaran berhasil divalidasi, kami sedang memproses pesanan Anda', 'failure' => 'Kami tidak dapat memvalidasi pembayaran Anda, harap coba lagi', 'tryagain' => 'Coba lagi', 'validating' => 'Kami memvalidasi pembayaran Anda harap tunggu', 'thankyou' => 'Terima kasih', 'transactionid' => 'ID transaksi', 'validationfailure' => 'Maaf, kami tidak dapat menemukan transaksi Anda atau masih belum terkonfirmasi, silakan coba lagi'));
        }
        if ($_GET['lang'] == 'it') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Paga Ora', 'pay' => 'Paga usando Criptovalute', 'guide0' => 'Si essere partenza per pagare', 'guide1' => 'Per assicurare che si chi volere mandato il moneta, piacere inserire primo 3 & ultimo 3 di vostro indirizzo', 'guide' => 'Paga utilizzando qr o invia la transazione all\'indirizzo successivo, quindi fai clic su ho pagato per passare alla fase di verifica', 'ivepaid' => 'Ho pagato', 'nextstep' => 'Convalidare', 'step2' => 'Per assicurarti di aver inviato il denaro, inserisci i primi 3 caratteri e gli ultimi 3 caratteri del tuo indirizzo Bitcoin', 'success' => 'Grazie, il pagamento è stato convalidato con successo, stiamo elaborando il tuo ordine', 'failure' => 'Non possiamo convalidare il tuo pagamento, per favore riprova', 'tryagain' => 'Provare ancora', 'validating' => 'Stiamo convalidando il tuo pagamento piacere attesa', 'thankyou' => 'Ringraziare si', 'transactionid' => 'ID transazione', 'validationfailure' => 'Siamo spiacenti, non riusciamo a trovare la transazione o non è stata ancora confermata, riprova'));
        }
        if ($_GET['lang'] == 'ja') {
            $sf = 'var messages ='.json_encode(array('paynow' => '今払う', 'pay' => 'ビットコインを使用して支払う', 'guide0' => 'あーた いらっしゃる いらして にかけて 引合う', 'guide1' => '送金者を確認するために、ビットコインアドレスの最初の3文字と最後の3文字を挿入してください', 'guide' => 'qrを使用して支払うか、トランザクションを次のアドレスに送信してから、[支払った]をクリックして確認ステップにジャンプします', 'ivepaid' => '支払いました', 'nextstep' => '検証', 'step2' => '送金者が確実に送金できるように、アドレスの最初の3文字と最後の3文字を入力してください', 'success' => 'ありがとうございます。お支払いは正常に検証されました。ご注文を処理しています', 'failure' => 'お支払いを確認できません。もう一度お試しください', 'tryagain' => '１発 も', 'validating' => '俺たち いらっしゃる validate あなたの 勘定 お願いいたします お預け', 'thankyou' => 'あじゃじゃしたー', 'transactionid' => 'トランズアクションイード', 'validationfailure' => '申し訳ありませんが、取引が見つからないか、まだ確認されていません。もう一度お試しください'));
        }
        if ($_GET['lang'] == 'ko') {
            $sf = 'var messages ='.json_encode(array('paynow' => '지금 지불하세요', 'pay' => '비트 코인으로 지불', 'guide0' => '너 아르 가는중 내다', 'guide1' => '송금한 사람이 맞는지 확인하려면 비트코인 ​​주소의 처음 3자리와 마지막 3자리를 입력하세요.', 'guide' => 'qr을 사용하여 결제하거나 다음 주소로 거래를 보낸 다음 결제 완료를 클릭하여 확인 단계로 이동합니다.', 'ivepaid' => '나는 지불했다', 'nextstep' => '확인', 'step2' => '송금 한 사람을 확인하려면 주소의 처음 3 자 및 마지막 3자를 입력하십시오.', 'success' => '감사합니다. 결제가 성공적으로 확인되었습니다. 주문을 처리하고 있습니다.', 'failure' => '결제를 확인할 수 없습니다. 다시 시도하십시오.', 'tryagain' => '애쓰다 다시', 'validating' => '우리 are validate 당신의 지불 제발 기다리다', 'thankyou' => '감사 너', 'transactionid' => '거래 아이디', 'validationfailure' => '죄송합니다. 거래를 찾을 수 없거나 아직 확인되지 않았습니다. 다시 시도해 주세요.'));
        }
        if ($_GET['lang'] == 'pl') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Zapłać Teraz', 'pay' => 'Płacić za pomocą crypto', 'guide0' => 'Zamierzasz zapłacić', 'guide' => 'Zapłać za pomocą qr lub wyślij transakcję na następny adres, a następnie kliknij Zapłaciłem, aby przejść do etapu weryfikacji', 'ivepaid' => 'Zapłaciłem', 'nextstep' => 'Uprawomocnić', 'step2' => 'Aby upewnić się, że wysłałeś pieniądze, wprowadź pierwsze 3 znaki i 3 ostatnie znaki adresu', 'success' => 'Dziękujemy, płatność została pomyślnie zweryfikowana, Twoje zamówienie jest przetwarzane', 'failure' => 'Nie możemy zweryfikować Twojej płatności, spróbuj ponownie', 'tryagain' => 'Próbować ponownie', 'validating' => 'My jesteś zatwierdzać twój płatność podobaćsię czekać', 'thankyou' => 'Dziękować ty', 'transactionid' => 'Interes ID', 'validationfailure' => 'Przepraszamy, nie możemy znaleźć Twojej transakcji lub nadal nie została ona potwierdzona, spróbuj ponownie'));
        }
        if ($_GET['lang'] == 'pt') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Pague Agora', 'pay' => 'Pagar usando crypto', 'guide0' => 'Você são acompanhado aquilotado prestaratenção', 'guide' => 'Pague usando qr ou envie a transação para o próximo endereço e clique em paguei para ir para a etapa de verificação', 'ivepaid' => 'Eu paguei', 'nextstep' => 'Validar', 'step2' => 'Para garantir que foi você quem enviou o dinheiro, digite os primeiros 3 caracteres e os 3 últimos caracteres do seu endereço', 'success' => 'Obrigado, o pagamento foi validado com sucesso, estamos processando seu pedido', 'failure' => 'Não podemos validar o seu pagamento, tente novamente', 'tryagain' => 'Injuriador outravez', 'validating' => 'ViaLáctea são validar tresfoliar entregacontrapagamento Porfavor aguardar', 'thankyou' => 'Reconhecimento você', 'transactionid' => 'Negócio ID', 'validationfailure' => 'Desculpe, não conseguimos encontrar sua transação ou ela ainda não foi confirmada. Tente novamente'));
        }
        if ($_GET['lang'] == 'ru') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'заплатить сейчас', 'pay' => 'Платить с помощью биткойнов', 'guide0' => 'Ты есть ход айда-ко возмездие', 'guide' => 'Оплатите с помощью qr или отправьте транзакцию на следующий адрес, затем нажмите Я заплатил, чтобы перейти к этапу проверки', 'ivepaid' => 'Я заплатил', 'nextstep' => 'Подтверждать', 'step2' => 'Чтобы убедиться, что вы отправили деньги, введите первые 3 символа и последние 3 символа вашего адреса', 'success' => 'Спасибо, оплата прошла успешно, мы обрабатываем ваш заказ', 'failure' => 'Мы не можем подтвердить ваш платеж, попробуйте еще раз', 'tryagain' => 'Отведывать вновь', 'validating' => 'Мы есть легализовать свой взнос нравиться выжидать', 'thankyou' => 'Благодарите ты', 'transactionid' => 'Ведение втрд', 'validationfailure' => 'К сожалению, мы не можем найти вашу транзакцию или она еще не подтверждена, попробуйте еще раз'));
        }
        if ($_GET['lang'] == 'sv') {
            $sf = 'var messages ='.json_encode(
                array('paynow' => 'Betala Nu', 'pay' => 'Betala med crypto', 'guide0' => 'Dej är gå à avlöna', 'guide' => 'Betala med qr eller skicka transaktion till nästa adress och klicka sedan på jag har betalat för att hoppa till verifieringssteget', 'ivepaid' => 'Jag har betalat', 'nextstep' => 'Bekräfta', 'step2' => 'För att försäkra dig om att du som skickade pengarna, ange första 3 tecken och 3 sista tecken i din adress', 'success' => 'Tack, betalningen validerades framgångsrikt, vi behandlar din beställning', 'failure' => 'Vi kan inte validera din betalning. Försök igen', 'tryagain' => 'Försöka åter', 'validating' => 'Vi are validera din betalning tilltala tid', 'thankyou' => 'Avtacka dej', 'transactionid' => 'Transaktion ID', 'validationfailure' => 'Vi kan tyvärr inte hitta din transaktion eller så har den fortfarande inte bekräftats, försök igen

                    ')
            );
        }
        if ($_GET['lang'] == 'es') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Pagar Ahora', 'pay' => 'Pagar con Bitcoin', 'guide0' => 'Tú ser ira pagar', 'guide' => 'Pague usando qr o envíe la transacción a la siguiente dirección y luego haga clic en he pagado para saltar al paso de verificación', 'ivepaid' => 'He pagado', 'nextstep' => 'Validar', 'step2' => 'para asegurarse de que fue usted quien envió el dinero, ingrese los primeros 3 caracteres y los 3 últimos caracteres de su dirección', 'success' => 'Gracias, el pago se validó correctamente, estamos procesando su pedido.', 'failure' => 'No podemos validar su pago. Vuelva a intentarlo.', 'tryagain' => 'Intentar otravez', 'validating' => 'Nosotros ser validar tu{s} pago gustar', 'thankyou' => 'Agradecer tú', 'transactionid' => 'Transacción ID', 'validationfailure' => 'Lo sentimos, no podemos encontrar su transacción o aún no está confirmada, intente nuevamente'));
        }
        if ($_GET['lang'] == 'tr') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Şimdi öde', 'pay' => 'Bitcoin kullanarak öde', 'guide0' => 'Siz oluyorlar gidiş karşı ödemek', 'guide' => 'qr kullanarak ödeme yapın veya işlemi bir sonraki adrese gönderin ve ardından doğrulama adımına atlamak için ödedim\'i tıklayın', 'ivepaid' => 'ödedim', 'nextstep' => 'Doğrulamak', 'step2' => 'Parayı gönderenin sizden emin olmak için, lütfen  adresinizin ilk 3 karakterini ve son 3 karakterini girin', 'success' => 'Teşekkürler, ödeme başarıyla onaylandı, siparişinizi işliyoruz', 'failure' => 'Ödemenizi doğrulayamıyoruz, lütfen tekrar deneyin', 'tryagain' => 'Denemek birdaha', 'validating' => 'Biz are doğrulamak senin ödeme memnunetmek beklemek', 'thankyou' => 'Teşekküretmek siz', 'transactionid' => 'Işlembilinçaltı', 'validationfailure' => 'Üzgünüz, işleminizi bulamıyoruz veya hala onaylanmadı, lütfen tekrar deneyin'));
        }
        if ($_GET['lang'] == 'vi') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'Thanh Toán Ngay', 'pay' => 'Thanh toán bằng bitcoin', 'guide0' => 'Ödeyeceksin', 'guide' => 'Thanh toán bằng qr hoặc gửi giao dịch đến địa chỉ tiếp theo sau đó nhấp vào Tôi đã thanh toán để chuyển sang bước xác minh', 'ivepaid' => 'Tôi đã thanh toán', 'nextstep' => 'Xác nhận', 'step2' => 'để đảm bảo rằng bạn là người đã gửi tiền, vui lòng nhập 3 ký tự đầu tiên và 3 ký tự cuối cùng trong địa chỉ của bạn', 'success' => 'Cảm ơn bạn, thanh toán đã được xác thực thành công, chúng tôi đang xử lý đơn đặt hàng của bạn', 'failure' => 'Chúng tôi không thể xác thực thanh toán của bạn, vui lòng thử lại', 'tryagain' => 'Sựthử lại', 'validating' => 'Chúngtôi A(đơnvịdiệntíchruộngđất làmchocógiátrị củaanh sựtrảtiền làmvuilòng sựchờđợi', 'thankyou' => 'Cámơn anh', 'transactionid' => 'ID giao dịch', 'validationfailure' => 'Xin lỗi, chúng tôi không thể tìm thấy giao dịch của bạn hoặc giao dịch vẫn chưa được xác nhận, vui lòng thử lại'));
        }
        if ($_GET['lang'] == 'uk') {
            $sf = 'var messages ='.json_encode(array('paynow' => 'платити зараз', 'pay' => 'Оплачуйте за допомогою біткойнів', 'guide0' => 'Ти збираєшся заплатити', 'guide' => 'Оплатіть за допомогою цього qr або надішліть на наступну адресу, після чого натисніть я заплатив', 'ivepaid' => 'я заплатив', 'nextstep' => 'перевірити', 'step2' => 'щоб переконатися, що ви, хто надіслав гроші, введіть перші 3 символи та 3 останні символи своєї адреси', 'success' => 'Дякуємо, платіж підтверджено успішно, ми обробляємо Ваше замовлення', 'failure' => 'Ми не можемо підтвердити ваш платіж, спробуйте ще раз', 'tryagain' => 'Спробуйте ще раз', 'validating' => 'Ми перевіряємо ваш платіж зачекайте', 'thankyou' => 'Дякую', 'transactionid' => 'ID транзакції', 'validationfailure' => 'На жаль, ми не можемо знайти вашу трансакцію або вона все ще не підтверджена. Спробуйте ще раз'));
        }
    } else {
        $sf = 'var messages ='.json_encode(array('paynow' => 'Pay with CryptoCheckout', 'pay' => 'Pay Using Crypto', 'guide0' => 'You\'re going to pay', 'guide1' => 'To ensure that you who will sent the money, please insert first 3 charcters & last 3 charcters of your Bitcoin address', 'guide' => 'Pay using this qr or send to the next address then click i\'ve paid', 'ivepaid' => 'I\'ve paid', 'nextstep' => 'Next step', 'step2' => 'To ensure that you who sent the money, please enter first 3 character & 3 last character of your address', 'success' => 'Thank you, payment were validated successfully, we\'re processing your order', 'failure' => 'We can\'t validate your payment, please try again', 'tryagain' => 'Try again', 'validating' => 'We\'re validating your payment please wait', 'thankyou' => 'Thank you', 'transactionid' => 'Transaction ID', 'validationfailure' => 'Sorry, we can\'t find your transaction or it still not confirmed, please try again'));
    }
    if (isset($_GET['curr'])) {
        if (strpos($_GET['curr'], '+') !== false) {
            $cs = explode('+', $_GET['curr']);
            $n = array();
            foreach ($cs as $c) {
                $n[] = '"'.$c.'"';
            }
            $curr = 'curr=['.implode(',', $n).']';
        } else {
            $cs = explode(' ', $_GET['curr']);
            $n = array();
            foreach ($cs as $c) {
                $n[] = '"'.$c.'"';
            }
            $curr = 'curr=['.implode(',', $n).']';
        }
    } else {
        $curr = 'curr=[\'usdt\',\'btc\',\'eth\',\'sol\',\'avax\',\'dot\',\'ada\',\'xtz\',\'xmr\']';
    }


    include "txtdb.php";
    $db = new TxtDb();
    $as = $db->select('merchants', array('as' => $_GET['id']));
    $address = json_encode($as[array_keys($as)[0]]['address']);
    $sf .= ', address='.$address.' , amount=[] ,type="",as="'.$_GET['id'].'", hash="" ,'.$curr.';'.file_get_contents('crypto-woocommerce.min.js');
    //header('Content-Description: File Transfer');
    //header('Content-Disposition: attachment; filename=gopay.js');
    //header('Expires: 0');
    //header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: 3040');
    header("Content-Type: text/javascript");
    //readfile('yield'.$_SERVER['REQUEST_URI']);
    echo $sf;


    die();
} elseif (empty($_GET) && empty($_POST) && empty($_FILES) && json_decode(file_get_contents('https://iplocation.cryptocheckout.co/?ip='.$_SERVER['REMOTE_ADDR'].'&token=65c7a13504305251bf2c256db13d5113'))->country !== 'Algeria') {
    //json_decode(file_get_contents('https://iplocation.cryptocheckout.co/?ip='.$_SERVER['REMOTE_ADDR'].'&token=65c7a13504305251bf2c256db13d5113'))->country !=='Algeria' &&

    ?>
        <!DOCTYPE html>
        <html style="background-color: white; font-family: Arial;">
        
        <head>
            <link rel="stylesheet" href="stylesheet.css">
            <!-- Google tag (gtag.js) -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-D4TP56KZPV"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', 'G-D4TP56KZPV');
            </script>
            <!-- Google Tag Manager -->
            <script>
                (function(w, d, s, l, i) {
                    w[l] = w[l] || []; w[l].push({
                        'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                    }); var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer'?'&l='+l: ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl; f.parentNode.insertBefore(j, f);
                })(window, document, 'script', 'dataLayer', 'GTM-58MV9L2W');
            </script>
            <!-- End Google Tag Manager -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css">
            <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
            <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png" />
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

            <script src="/jquery.min.js"></script>

            <meta charset="utf-8">
            <meta name="keywords" content="binance pay alternative, coingate alternative, crypto pay alternative, nowpayments alternatives, integrate bitcoin, bitcoin integration, bitcoin payment, accept payment, payment gateway, bitcoin, bitpay alternatives, coinbase checkout alternatives, fintech, defi, dapps, dapp, crypto checkout for woocommerce, crypto payments for woocommerce" />
            <meta property="og:url" content="https://cryptocheckout.co/" />
            <meta property="og:title" content="Crypto checkout for online businesses" />
            <meta name="og:description" content="Secure, safe, reliable, decentralize crypto payments gateway, support multi crypto currencies & e-commerce platforms" />
            <META NAME="author" CONTENT="" />
            <title>CryptoCheckout | Secure crypto payment gateway</title>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/pbkdf2.js"></script>
              <script src="https://www.paypal.com/sdk/js?client-id=Afa59djtAPgttBigmajXgJ4WLH3bZwVbbDoIBfgzZG6zFqJMiK7E8Szak0Um6ml1smk9eF38wjJjNiai&currency=USD" ></script>
        </head>



  

        <body style="background-color:white;font-family: Arial;">
        <header>
         <div id="menu" style="position:relative;margin-right: auto;margin-left: auto;">
                    <a href="#" class="open-button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                <div id="logo">
                    <span id="spanlogo"></span>
                    <h3 id="logotext" >CryptoCheckout</h3>
                </div>
                <nav>
                    <ul>
                        <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/how-it's-secure" >How it's secure?</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/features" >Features</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/fees" >Fees</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/coming-next" >Coming
                        Next</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://cryptocheckout.co/changelog" >Changelog</a>
                </p>
            </li>
            <li>
                <p style="text-align: center;display: inline-block;">
                    <a href="https://twitter.com/CryptoCStatus" target="_black">Status<span id="odicon" style="width: 20px;height: 20px;position: relative;background-image: url('https://cryptocheckout.co/newtab.png');display: inline-block;background-repeat: no-repeat;top: 6px;left: 5px;margin-right: 5px;"></span></a>
                </p>
            </li>
                </ul>
                </nav>

            </div>
            </header>
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-58MV9L2W"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
            <div id="greeting" style="position: relative;width: 100%;margin-right:auto;margin-left:auto;margin-top:80px">

                <h1 id="mainheading" style="text-align: center">Catch the power of the blockchain</h1>
                <ul id="features" style="list-style: none;display:flex;position:relative;clear:both;text-align: center;left:20%;top:30px;padding:30px">
                    <li>Save on each transaction<span class="status_round" style="width: 25px;
                        height: 25px;
                        border-radius: 50px;
                        background-image: url('https://cryptocheckout.co/check-green.png');
                        display: inline-block;
                        top: 6px;
                        position: relative;
                        margin-left: 5px;"></span></li>
                        <li>Target any client<span class="status_round" style="width: 25px;
                        height: 25px;
                        border-radius: 50px;
                        background-image: url('https://cryptocheckout.co/check-green.png');
                        display: inline-block;
                        top: 6px;
                        position: relative;
                        margin-left: 5px;"></span></li>
                        <li>Use your private addresses<span class="status_round" style="width: 25px;
                        height: 25px;
                        border-radius: 50px;
                        background-image: url('https://cryptocheckout.co/check-green.png');
                        display: inline-block;
                        top: 6px;
                        position: relative;
                        margin-left: 5px;"></span></li>
                </ul>
                <!--<p id="feature1" style="position:relativeclear:both;text-align: center"></br>-->
            </p>
            <p style="text-align: center"></p>


            <div id="test2" style="display: block;clear: both;width: 40%; margin-top: 50px; margin-right: auto; margin-left: auto">
           
                <label for="email">Your email</label>
                <input id="email" type="email" placeholder="Your email address" style="width: 100%;line-height:2;font-size:22px;margin-top:5px;border:1px solid #dfdfdf;border-radius:10px" />
                <label for="password" style="display:none;position: relative;top: 20px;">Password (optional)</label>
                <input id="password" type="password" placeholder="Type a password" style="display: none;width: 100%;line-height:2;font-size:22px;margin-top:5px;border:1px solid #dfdfdf;border-radius:10px;position:relative;top: 20px;" />


              <label for="coins" style="width:100%;float:left;margin-top:20px;position:relative">Insert at least one address</label>
                <div id="coins" style="width:100%;float:left;clear:both;position:relative">
                <div id="cusdt" style="width:100%;float:left;clear:both">
<label for="cusdt">
<span id="cusdti" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/usdt.png')"></span>
<input type="text" id="usdtaddr" placeholder="Insert your USDT(BEP20) address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px" />
</label>
</div>    
                <div id="cbtc" style="width:100%;float:left;clear:both">
<label for="cbtc">
<span id="cbtci" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/btc.png')"></span>
<input type="text" id="btcaddr" placeholder="Insert your Bitcoin address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px" />
</label>
</div>
<div id="ceth" style="width:100%;float:left;clear:both">
<label for="ceth">
<span id="cethi" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/eth.png')"></span>
<input type="text" id="ethaddr" placeholder="Insert your Ethereum address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px"/>
</label>
</div>
<div id="csol" style="width:100%;float:left;clear:both">
<label for="csol">
<span id="csoli" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/sol.png')"></span>
<input type="text" id="soladdr" placeholder="Insert your Solana address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px" />
</label>
</div>
<div id="cavax" style="width:100%;float:left;clear:both">
<label for="cavax">
<span id="cavaxi" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/avax.png')"></span>
<input type="text" id="avaxaddr" placeholder="Insert your Avalanche C Chain address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px"/>
</label>
</div>
<div id="cdot" style="width:100%;float:left;clear:both">
<label for="cdot">
<span id="cdoti" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/dot.png')"></span>
<input type="text" id="dotaddr" placeholder="Insert your Polkadot address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px"/>
</label>
</div>
<div id="cada" style="width:100%;float:left;clear:both">
<label for="cada">
<span id="cadai" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/ada.png')"></span>
<input type="text" id="adaaddr" placeholder="Insert your Cardano address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px" />
</label>
</div>
<div id="cxtz" style="width:100%;float:left;clear:both">
<label for="cxtz">
<span id="cxtzi" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/xtz.png')"></span>
<input type="text" id="xtzaddr" placeholder="Insert your Tezos address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px" />
</label>
</div>
<div id="cxmr" style="width:100%;float:left;clear:both">
<label for="cxmr">
<span id="cxmri" style="width:32px;height:32px;display:inline-block;background-image: url('https://cryptocheckout.co/xmr.png')"></span>
<input type="text" id="xmraddr" placeholder="Insert your Monero address" style="margin-bottom:20px;line-height:2;float:right;width: 80%;font-size:22px;border:1px solid #dfdfdf;border-radius:10px" />
</label>
</div>
</div>
<label for="plans" style="position:relative;clear:both;margin-top: 20px;float:left;clear:both">Choose your plan</label>
 <div id="plans" style="float:left;clear:both">
    <label for="free" style="float:left;clear:both">Free (0.00$ 5transactions/month)
        <input type="radio" id="free" class="plan" name="plan" style="width:32px;height:32px;float:left" value="free" />
    </label>
    <label for="paid" style="float:left;clear:both">Paid (2.00$ ∞transactions/month)
        <input type="radio" id="paid" class="plan" name="plan" style="width:32px;height:32px;float:left" value="paid" />
    </label>
</div>

            <?php if ($_SESSION['did'] == true) {
                ?>
                    <div class="captcha" style="position:relative; width: 100px;margin-top: 20px;">
                        <?php
                        $captcha = new CaptchaBuilder();
                        $captcha->build();
                        //print_r($captcha->getPhrase());

                        if (empty($_SESSION['phrase']) || $_SESSION['phrase'] == 'none') {
                            $_SESSION['phrase'] = $captcha->getPhrase();
                        }
                        if (empty($_SESSION['inline']) || $_SESSION['inline'] == 'none') {
                            $_SESSION['inline'] = $captcha->inline();
                        }


                        ?>
                        <img style="display: block;  margin-right: auto;  margin-left: auto;  margin-top: 5px;border-radius: 10px" src="<?php echo $_SESSION['inline'] ?>" />
                        <input id="captcha" maxlength="5" style="width: 100%;line-height: 2;font-size: 22px;margin-top: 5px;border: none;border-radius: 10px;" type="text" maxlength="5" placeholder="XXXXX" />

                    </div>
                    <?php
            } ?>
                               <div id="paypal-button-container" style="position: relative; top:20px;clear:both;margin-right:auto;margin-left:auto"></div>
                <div id="cc" style="position: relative; margin-left: auto;margin-right: auto;display: block; ;margin-top:20px"></div>
                <div id="tos" style="float:left;clear:both;position:relative;margin-top:20px">
    <label for="terms">I've read & agree with the CryptoCheckout Inc's <a href="https://cryptocheckout.co/terms" target="_blank" >Terms of service</a> and <a href="https://cryptocheckout.co/privacy-policy" target="_blank" >Privacy Policy</a>
        <input type="checkbox" id="terms" name="terms" style="width:32px;height:32px;float:left" />
    </label>
</div>


                <div id="all" style="margin-right:auto;margin-left:auto;clear:both;margin-bottom: 30px;    width: 50%;    font-size: 16px;    border: none;    background-color: cadetblue;    height: 52px;    border-radius: 25px;    margin-top: 20px;    position: relative;    color: white;    font-weight: 600;" class="snippet" data-title=".dot-flashing">                    
                <p id="alltext" style="text-align: center;position:relative;right:10px;top:15px">
                        Generate merchant ID
                    </p>
                    <span id="allicon" style="width: 21px;height: 21px;background-image: url(https://cryptocheckout.co/right-white.png);position: relative;margin-right: auto;margin-left: auto;position: relative;display: block;left: 90px;bottom: 22px;"></span>
                    <div class="stage" style="position:relative;top:18px;margin-left:auto;margin-right:auto;display:block;width:10%">
                        <div class="dot-flashing"></div>
                    </div>
                </div>

                <div id="raddr"></div>
                <script>

                </script>
            </div>


            <script>
                var curr0 = fresponse = '',
                downlaod = appended = ppinitiated = sent = false,
                receivable = cost = ourfee = 0,
                regex = new RegExp(/^\+?[0-9(),.-]+$/);
                function CryptoJSAesDecrypt(enctext, encpass) {
                    var salt = CryptoJS.enc.Hex.parse(enctext.salt);
                    var iv = CryptoJS.enc.Hex.parse(enctext.iv);
                    /*var hashkey = CryptoJS.PBKDF2(encpass, enctext.salt, {hasher: CryptoJS.algo.SHA512, keySize: 8, iterations: 999});*/
                    var decrypted = CryptoJS.AES.decrypt(enctext.ciphertext, enctext.key, {
                        iv: enctext.iv
                    });
                    return atob(decrypted.toString());
                }
                function checkBin(n) {
                    return/^[01][1,64]$/.test(n)}
                function hex2bin(n) {
                    if (!checkBin(n))return 0; return parseInt(n, 2).toString(2)}
                function isEmail(email) {
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return regex.test(email);
                }
                function sf_decode(str, pass) {
                    for (i = 0; i <= 5; i++) {
                        str = str.substring(0, Number(pass.charAt(i))) + str.substring(Number(pass.charAt(i))+1, str.length);
                    }
                    return str;
                }
                function fromBinary(encoded) {
                    const binary = atob(encoded);
                    const bytes = new Uint8Array(binary.length);
                    for (let i = 0; i < bytes.length; i++) {
                        bytes[i] = binary.charCodeAt(i);
                    }
                    return String.fromCharCode(...new Uint16Array(bytes.buffer));
                }

                var CryptoJSAesJson = {
                    stringify: function (cipherParams) {
                        var j = {
                            ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
                        if (cipherParams.iv) j.iv = cipherParams.iv.toString();
                        if (cipherParams.salt) j.s = cipherParams.salt.toString();
                        return JSON.stringify(j);
                    },
                    parse: function (jsonStr) {
                        var j = JSON.parse(jsonStr);
                        var cipherParams = CryptoJS.lib.CipherParams.create({
                            ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
                        if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
                        if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
                        return cipherParams;
                    }
                }
                function getCookie(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                }
                //alert(getCookie('PHPSESSID'));

                key = getCookie('PHPSESSID');

        

var hidden = true;
                (function($) {
                    

                     
    


    /* Hamburger menu animation */
    $('.open-button').click(function(){
      $(this).toggleClass('open');
      if(hidden==true){
        
        $('#menu p').show();
        $('#menu').css({'background-color':'white','position':'fixed','min-height':'100%','height':'100%','right':'20px'});
        $('#menu ul').css({'position':'relative','top':'150px'});
        $('body').css({'overflow':'hidden'})
        hidden = false;
      }else{
          $('#menu p').hide();
         $('#menu').css({'background-color':'white','position':'fixed','min-height':'200px','height':'200px'})
         $('body').css({'overflow':'scroll'})
          hidden=true;
      }
      
    });

   /* Menu fade/in out on mobile */
    $(".open-button").click(function(e){
        e.preventDefault();
        $(".mobile-menu").toggleClass('open');
    });


                    $('#all').on('click',
                        function(e) {                    
                         
                                if ($('#email').val() !== '') {
                                    
                                    if (isEmail($('#email').val())) {
                                    if($('#usdtaddr').val()!==''||$('#btcaddr').val()!==''||$('#ethaddr').val()!==''||$('#soladdr').val()!==''||$('#avaxaddr').val()!==''||$('#dotaddr').val()!==''||$('#adaaddr').val()!==''||$('#xtzaddr').val()!==''||$('#xmraddr').val()!==''){
                                    if($('.plan').val()=='free'){
               
                      if ($('#captcha').length > 0) {
                                            if ($('#captcha').val() !== '' && typeof $('#captcha').val() !== 'undefined' && $('#captcha').val().length == 5) {
                                                if($('#terms').is(':checked')){                 
                                                curr0 = 'usdt+btc+eth+sol+avax+dot+xtz+ada+xmr';
                                                if (curr0 !== '') {
                                                    $('#alltext,#allicon').hide();
                                                    $('#all .stage').show();
                                                    $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&email='+$('#email').val()+'&captcha='+$('#captcha').val()+'&password='+encodeURIComponent($('#password').val())+'&plan=free&external=true&usdt='+$('#usdtaddr').val()+'&btc='+$('#btcaddr').val()+'&eth='+$('#ethaddr').val()+'&sol='+$('#soladdr').val()+'&avax='+$('#avaxaddr').val()+'&dot='+$('#dotaddr').val()+'&xtz='+$('#xtzaddr').val()+'&xmr='+$('#xmraddr').val()), key, {
                                                        format: CryptoJSAesJson
                                                    }).toString()), function(response) {
                                                        $('#all .stage').hide();
                                                        $('#alltext, #allicon').show();
                                                        if (response.result === true) {
                                                            $('label[for="password"]').remove();
                                                            $('#password').remove();
                                                            

                                                            


                                    $('.new, label[for="new"]').remove();
                                                            $('.captcha').remove();
                r = JSON.parse(CryptoJS.AES.decrypt(atob(response.msg), key, {
                                                            format: CryptoJSAesJson
                                                        }).toString(CryptoJS.enc.Utf8));
                                                        try {

                                                            $('#raddr').append('<p style="font-size:58px;text-align: center" >🎉🎉🥳 Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/appGlobal web icon🎉🎉🥳</p><br/>');
                                                        }catch(e) {
                                                            alert(e);
                                                        }
                                                        } else {
                                                            alert(response.msg);
                                                        }




                                                    });
                                                } else {
                                                    alert('Please select at least one currency');
                                                }
                                                                  }else{
                      alert('You must agree with our terms of service  & our privacy policy')
                  }   
                                            } else {
                                                alert('Captcha is required');
                                            }
                                        } else {
                             if($('#terms').is(':checked')){                             curr0 = 'usdt+btc+eth+sol+avax+dot+xtz+ada+xmr';
                                            if (curr0 !== '') {
                                                $('#alltext,#allicon').hide();
                                                $('#all .stage').show();
                                                $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&email='+$('#email').val()+'&password='+encodeURIComponent($('#password').val())+'&plan=free&external=true&usdt='+$('#usdtaddr').val()+'&btc='+$('#btcaddr').val()+'&eth='+$('#ethaddr').val()+'&sol='+$('#soladdr').val()+'&avax='+$('#avaxaddr').val()+'&dot='+$('#dotaddr').val()+'&xtz='+$('#xtzaddr').val()+'&xmr='+$('#xmraddr').val()), key, {
                                                    format: CryptoJSAesJson
                                                }).toString()), function(response) {

                                                    $('#all .stage').hide();
                                                    $('#alltext, #allicon').show();
                                                    if (response.result === true) {
                                                        $('label[for="password"]').remove();
                                                        $('#password').remove();


          $('.captcha').remove();
          
                                    r = JSON.parse(CryptoJS.AES.decrypt(atob(response.msg), key, {
                                                            format: CryptoJSAesJson
                                                        }).toString(CryptoJS.enc.Utf8));
                                                        try {

                                                            $('#raddr').append('<p style="font-size:58px;text-align: center" >🎉🎉🥳 Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app 🎉🎉🥳</p><br/>');
                                                        }catch(e) {
                                                            alert(e);
                                                        }                                        } else {
                                                        alert(response.msg);
                                                    }




                                                });
                                            }else{
                                                alert('Please select at least one currency');
                                            }
                                        
                                        }else{
                   alert('You must agree with our terms of service  & our privacy policy')
                  }   
                      
                    }
                    
                                        }else if($('.plan').val()=='paid'){
                                        if($('#terms').is(':checked')){
                                      alert('Pay to continue')      
                                        }else{
                                            alert('You must agree with our terms of service & our privacy policy')
                                        }
                                        }else{
                                            alert('You should select a plan');
                                        }                           
                                        }else{
                         alert('You must provide at least one address')
                                
                                
}
 }else{
                                        alert('Please insert a valid email address');
                                    }
              }else{
                                     alert('You must provide an email address');
                                 }
                
                           

                            
                        });

                   $('.plan').on('change',function(){
                     
                       if($(this).val()=='paid'){
                           $('#paypal-button-container').html('');
                        paypal.Buttons({
                                locale: 'en_US',
                                style: {
                                    color:  'blue',
                                    shape:  'pill',
                                    label:  'pay',
                                    height: 55,
                                },
            
                                
                
                                // Set up the transaction
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                              value: 2,
                                            }
                                        }]
                                    });
                                },
                                // Finalize the transaction
                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(details) {
                                        var transactionId = details.purchase_units[0].payments.captures[0].id;
                                        (function($){
                                            $('#paypal-button-container').html('');
                                            alert('Payment authorized ✅ please wait....')
                                            
                                                                $('#alltext,#allicon').hide();
                                                $('#all .stage').show();
                                                $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&email='+$('#email').val()+'&password='+encodeURIComponent($('#password').val())+'&plan=paid&external=true&usdt='+$('#usdtaddr').val()+'&btc='+$('#btcaddr').val()+'&eth='+$('#ethaddr').val()+'&sol='+$('#soladdr').val()+'&avax='+$('#avaxaddr').val()+'&dot='+$('#dotaddr').val()+'&xtz='+$('#xtzaddr').val()+'&xmr='+$('#xmraddr').val()), key, {
                                                    format: CryptoJSAesJson
                                                }).toString()), function(response) {

                                                    $('#all .stage').hide();
                                                    $('#alltext, #allicon').show();
                                                    if (response.result === true) {
                                                        $('label[for="password"]').remove();
                                                        $('#password').remove();


          $('.captcha').remove();
                                    r = JSON.parse(CryptoJS.AES.decrypt(atob(response.msg), key, {
                                                            format: CryptoJSAesJson
                                                        }).toString(CryptoJS.enc.Utf8));
                                                        try {

                                                            $('#raddr').append('<p style="font-size:58px;text-align: center" >🎉🎉🥳 Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app 🎉🎉🥳</p><br/>');
                                                        }catch(e) {
                                                            alert(e);
                                                        }                                        } else {
                                                        alert(response.msg);
                                                    }




                                                });
                                        })(jQuery);
                                    });
                                }
            }).render('#paypal-button-container'); 
                                showbtn('cc',
                        {
                            usd: 2
                        },
                        onApprove = function(transactionId) {
        (function($){
                                                                            $('#alltext,#allicon').hide();
                                                $('#all .stage').show();
                                                $.get('/?test='+btoa(CryptoJS.AES.encrypt(JSON.stringify('/?new='+curr0+'&email='+$('#email').val()+'&password='+encodeURIComponent($('#password').val())+'&plan=paid&external=true&usdt='+$('#btcaddr').val()+'&btc='+$('#btcaddr').val()+'&eth='+$('#ethaddr').val()+'&sol='+$('#soladdr').val()+'&avax='+$('#avaxaddr').val()+'&dot='+$('#dotaddr').val()+'&xtz='+$('#xtzaddr').val()+'&xmr='+$('#xmraddr').val()), key, {
                                                    format: CryptoJSAesJson
                                                }).toString()), function(response) {

                                                    $('#all .stage').hide();
                                                    $('#alltext, #allicon').show();
                                                    if (response.result === true) {
                                                        $('label[for="password"]').remove();
                                                        $('#password').remove();


          $('.captcha').remove();
                                    r = JSON.parse(CryptoJS.AES.decrypt(atob(response.msg), key, {
                                                            format: CryptoJSAesJson
                                                        }).toString(CryptoJS.enc.Utf8));
                                                        try {

                                                            $('#raddr').append('<p style="font-size:58px;text-align: center" >🎉🎉🥳 Your ID is: '+r['as']+' used to accept crypto currencies payments on your site/app 🎉🎉🥳</p><br/>');
                                                        }catch(e) {
                                                            alert(e);
                                                        }                                        } else {
                                                        alert(response.msg);
                                                    }




                                                });
               
        })(jQuery)
                        },
                        onError = function(error) {



                        })
                        $('#cntnr0').css({'margin-right':'auto','margin-left':'auto'})
                       }else{
                                                $('#paypal-button-container,#cc').html('');
                       }
                   }) 


                    //$('#all, .captcha').hide();
                    $('#all .stage').hide();


                })(jQuery);







            </script>
            <!--<script type="text/javascript" src="pbkdf2.js"></script>-->
            <div id="test7" style="clear:both;width: 100%; margin-top: 50px; margin-right: auto; margin-left: auto;top:50px;position:relative">
                <h4 style="text-align: center">Pricing comparison</h4>
                <p style="text-align:center">If you've a product costs 10$ sold 300 times in a month</p>
                <style>
                    table {
                        font-family: arial, sans-serif;
                        width: 100%;
                        table-layout: fixed;
                    }
                    tr {
                        width: 16%;
                        display: block;
                        float: left;

                    }
                    td, th {
                        width: 100%;
                        text-align: left;
                        padding: 8px;
                        display: block;
                        float: left;
                        text-align: center;
                    }


                    #pap {
                        display: block;
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('paypal.png');
                        background-repeat: no-repeat;
                        position: relative;
                        top: 12px;
                        margin-right: auto;
                        margin-left: auto;

                    }
                    #stripe {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('stripe.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                    #square {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('square.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                    
                    #binance {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('binance.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                    #coinbase {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('coinbase.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                    #cryptocheckout {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('cryptocheckout.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                </style>
                <table id="table">
                    <tr>
                        <th id="ppth"><span id="pap"></span><a style="position: relative;top: 15px;">Paypal</a></th>
                        <td id="pptd">You'll get 2823$, Paypal takes 177$ 
                        </td>
                    </tr>
                    <tr>
                        <th id="stripeth"><span id="stripe"></span><a style="position: relative;top: 15px;">Stripe</a></th>
                        <td>You'll get 2823$, Stripe takes 177$</td>
                    </tr>
                    <tr>
                        <th id="squareth"><span id="square"></span><a style="position: relative;top: 15px;">Square</a></th>
                        <td>You'll get 2823$, Square takes 177$</td>
                    </tr>
                    <tr>
                        <th id="binanceth"><span id="binance"></span><a style="position: relative;top: 15px;">Binance</a></th>
                        <td>You'll get 2850$, Binance takes 150$</td>
                    </tr>
                                        <tr>
                        <th id="coinbaseth"><span id="coinbase"></span><a style="position: relative;top: 15px;">Coinbase</a></th>
                        <td>You'll get 2970$, Coinbase takes 30$</td>
                    </tr>
                    <tr>
                        <th id="cryptocheckoutth"><span id="cryptocheckout"></span><a style="position: relative;top: 15px;">CryptoCheckout</a></th>
                        <td>You'll get 2998$, CryptoCheckout takes 2$</td>
                    </tr>

                </table>
                <br />
           
            </div>
            <div id="test5" style="clear:both;display:block;width: 47%; margin-top: 50px; margin-right: auto; margin-left: auto;top:50px;position:relative">
                <h4 style="text-align: center">CryptoCheckout pay button</h4>
                <div id="test"></div>
            </div>
            <script type="text/javascript" src="https://cryptocheckout.co/crypto.js?id=fa8b&lang=en"></script>
            <script>


                (function($) {


                    showbtn('test',
                        {
                            usd: 1
                        },
                        onApprove = function(transactionId) {
                            alert('Payment received the transaction ID is: '+transactionId+' (this is webhook trigged when payment approved)');
                        },
                        onError = function(error) {
                            alert('An error occured (this is webhook trigged when error occured)');


                        })

                })(jQuery)


            </script>
            <div id="test6" style="clear:both;width: 100%; margin-top: 50px; margin-right: auto; margin-left: auto;top:50px;position:relative">
                <h4 style="text-align: center">CryptoCheckout for e-commerce platforms</h4>
                <style>
                    table {
                        font-family: arial, sans-serif;
                        width: 100%;
                        table-layout: fixed;
                    }
                    #test6 tr {
                        width: 25%;
                        display: block;
                        float: left;

                    }
                    td, th {
                        width: 100%;
                        text-align: left;
                        padding: 8px;
                        display: block;
                        float: left;
                        text-align: center;
                    }


                    #woo {
                        display: block;
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('woo.png');
                        background-repeat: no-repeat;
                        position: relative;
                        top: 12px;
                        margin-right: auto;
                        margin-left: auto;

                    }
                    #shopify {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('shopify.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                    #prestashop {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('prestashop.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }
                    #opencart {
                        content: '';
                        width: 50px;
                        height: 50px;
                        background-image: url('opencart.png');
                        background-repeat: no-repeat;
                        position: relative;
                        margin-right: auto;
                        margin-left: auto;
                        display: block;
                    }

                </style>
                <table id="table">
                    <tr>
                        <th id="wooth"><span id="woo"></span><a style="position: relative;top: 15px;">Woocommerce</a></th>
                        <td id="wootd"><a href="https://wordpress.org/plugin/crypto-checkout-for-woocommerce/" target="_blank">View</a> or <a href="https://cryptocheckout.co/?download=true" target="_blank">Download</a><p>
                        <?php echo 'Downloads: '.$i ?>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <th id="shopifyth"><span id="shopify"></span><a style="position: relative;top: 15px;">Shopify</a></th>
                        <td>Coming soon</td>
                    </tr>
                    <tr>
                        <th id="prestashopth"><span id="prestashop"></span><a style="position: relative;top: 15px;">PrestaShop</a></th>
                        <td>Coming soon</td>
                    </tr>
                    <tr>
                        <th id="opencartth"><span id="opencart"></span><a style="position: relative;top: 15px;">OpenCart</a></th>
                        <td>Coming soon</td>
                    </tr>

                </table>
                <br />
                <div id="test"></div>
            </div>
        </div>
        <script>
            (function($) {
                $('#logo').on('click',function(){
                    window.location.assign('https://cryptocheckout.co');
                });
                $('#test5 #test').css({'width':'100%','margin-right':'auto','margin-left':'auto'});
                $('#cntnr0').css({'margin-right':'auto','margin-left':'auto'});
                $('#tos a').css({'color':'cadetblue'});
                $('#coins span').hide();
                    $('#coins input').css({'width':'100%'});
                    $('#test6').css('width', '50%');

                if (/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent)) {
                    $('#all').css({'width':'70%','height':'150px','border-radius':'100px','font-size':'32px'});
                    $('#greeting').css({'top':'200px'});
                    $('#mainheading').css({'font-size':'150px'});
                    $('#greeting,#menu').css({'clear':'both'});
                    $('#menu nav ul').css({'display':'block'});
                    $('#menu').css({'opacity':'1','width':'100%'});
                       $('#paypal-button-container').css({'width':'80%'});
                    $('table tr').css({
                        'width': '100%'
                    });
                    //$('#greeting,#test2,#api,#codeblock2,#codeblock3').css('width', '100%');
                    $('#test2').css({'width': '90%'});
                    $('#test2 input').css({'font-size': '58px','height':'150px'});
                    $('#codeblock3,#codeblock2').css('overflow-y', 'scroll');
                    //$('#test5,#api,#codeblock2,#codeblock3').css('width', '90%');

                    $('#woo,#shopify,#prestashop,#opencart').css({
                        'display': 'block', 'margin-right': 'auto', 'margin-left': 'auto', 'float': 'none', 'width': '200px', 'height': '200px'
                    });
                       $('#pap,#stripe,#square,#cryptocheckout,#binance,#coinbase').css({
                        'display': 'block', 'margin-right': 'auto', 'margin-left': 'auto', 'float': 'none', 'width': '200px', 'height': '200px'
                    });
                    $('#woo').css('background-image', 'url("https://cryptocheckout.co/woo-m.png")');
                                        $('#pap').css('background-image', 'url("https://cryptocheckout.co/paypal-m.png")');
                                                            $('#stripe').css('background-image', 'url("https://cryptocheckout.co/stripe-m.png")');
                                                                                $('#square').css('background-image', 'url("https://cryptocheckout.co/square-m.png")');
                                                                                                    $('#cryptocheckout').css('background-image', 'url("https://cryptocheckout.co/cryptocheckout-m.png")');
                  $('#binance').css('background-image', 'url("https://cryptocheckout.co/binance-m.png")');
                  $('#coinbase').css('background-image', 'url("https://cryptocheckout.co/coinbase-m.png")');
                    $('#shopify').css('background-image', 'url("https://cryptocheckout.co/shopify-m.png")');
                    $('#prestashop').css('background-image', 'url("https://cryptocheckout.co/prestashop-m.png")');
                    $('#opencart').css('background-image', 'url("https://cryptocheckout.co/opencart-m.png")');
                    $('td,th').css('font-size', '36px');
                    $('#cusdti').css({'background-image':'url("https://cryptocheckout.co/usdt-m.png")','width':'150px','height':'150px'});$('#cbtci').css({'background-image':'url("https://cryptocheckout.co/btc-m.png")','width':'150px','height':'150px'});$('#cethi').css({'background-image':'url("https://cryptocheckout.co/eth-m.png")','width':'150px','height':'150px'});$('#csoli').css({'background-image':'url("https://cryptocheckout.co/sol-m.png")','width':'150px','height':'150px'});$('#cdoti').css({'background-image':'url("https://cryptocheckout.co/dot-m.png")','width':'150px','height':'150px'});$('#cavaxi').css({'background-image':'url("https://cryptocheckout.co/avax-m.png")','width':'150px','height':'150px'});$('#cadai').css({'background-image':'url("https://cryptocheckout.co/ada-m.png")','width':'150px','height':'150px'});$('#cxtzi').css({'background-image':'url("https://cryptocheckout.co/xtz-m.png")','width':'150px','height':'150px'});$('#cxmri').css({'background-image':'url("https://cryptocheckout.co/xmr-m.png")','width':'150px','height':'150px'})

                 
                    //$('table').remove();
                    //$('#test6').append('');
                                        $('#menu').css({'position':'relative','width':'100%','height':'100%','min-height':'100%','width':'100%','z-index':'99999','min-width':'100%'})
                                        $('#menu p').css({'text-aligh':'center','clear':'both','display':'block','font-size':'64px'})
                                                          $('#menu p').hide();

                }else{
                    //$('#menu').prependTo('#greeting')
                    $('.open-button').hide();
                    $('#features li').css({'position':'relative','margin-left':'20px'});
                    
                    $('#test6').css('width','50%');
                    $('table').css({'position':'relative','top':'50px'});
                }
            })(jQuery)
        </script>

        <div id="api" style="position: relative; width: 55%; margin-right:auto; margin-left:auto; margin-top:80px;top:50px;margin-bottom:80px">
                            <h2 style="text-align: center">Integration</h2>
            <p style="text-align: left; font-size:18px">
            Script inclusion
            </p>
            <div id="codeblock0">
                <pre><code>&lt;script src=&quot;/jquery.min.js&quot; &gt;&lt;/script&gt;<br />
&lt;script src=&quot;https://cryptocheckout.co/crypto.js?id=YOUR-ID&amp;lang=LANGUAGE&quot;&gt;&lt;/script&gt;</code></pre>
            </div>
            <p style="text-align: left; font-size:18px">
                Accept only from specified  currencies like this
            </p>
            <div id="codeblock1">
                <pre><code>&lt;script src=&quot;/jquery.min.js&quot; &gt;&lt;/script&gt;<br />
&lt;script src=&quot;https://cryptocheckout.co/crypto.js?id=YOUR-ID&amp;curr=btc+avax&amp;lang=LANGUAGE&amp;&quot;&gt;&lt;/script&gt;</code></pre>
            </div>
            <p id="p2" style="text-align: left; font-size:18px">
                Initiatising the button
            </p>
            <div id="codeblock2">
                <pre><code>showbtn('MycontainerdivID',{usd:1},onApprove=function(transactionId){//Do something},onError=function(error){//Do something});</code></pre>
            </div>
            <p style="text-align: left; font-size:18px">
                Or your own prices:
            </p>
            <div id="codeblock3">
                <pre><code>showbtn('MycontainerdivID',{usd:1,btc:0.0000515632,eth:0.0009344048,sol:0.0301386377},onApprove=function(transactionId){//Do something},onError=function(error){//Do something});</code></pre>
            </div>
            <p style="text-align: left;font-size:18px">
                onApprove(transactionId) invocation
            </p>
            <div id="codeblock4">
                <pre><code>&lt;script&gt;

    // put it inside onApprove function
    (function($){
        $.get(&#39;https://yoursite.com/validatepaymentpage.php?transactionId=&#39;+transactionId,function(response){
            if(response.result == true ){
                // redirect to thank you page or show thank you
                window.location.assign(&#39;youtsite.com/thankyoupage.php?orderId=&#39;+response.orderId)
            }else{
                // show validation error
                alert(response.msg);
            }
        });
   }(jQuery)

&lt;/script&gt;</code></pre>
            </div>
            <p style="text-align: left; font-size:18px">
                The server side payment validation
            </p>
            <div id="codeblock5">
                <pre><code>&lt;?php
    if( isset($_GET[&#39;transactionId&#39;] ){
        $transaction_object = json_decode(file_get_contents(&#39;https://cryptocheckout.co/?transaction=&#39;.$_GET[&#39;transactionId&#39;]));
        if( abs(floatval($product_price)*floatval($transaction_object-&gt;rate)-floatval($transaction_object-&gt;amount))<=0.000001 &amp;&amp; $transaction_object-&gt;completed == true &amp;&amp; !in_array($_GET[&#39;transactionId&#39;],$transactions_list) ){
            blacklist_transaction($_GET[&#39;transactionId&#39;]);
            // generate orderId
            $orderId = md5(strval(round(microtime(true)*1000)));
            header(&#39;Content-type: application/json&#39;);
            echo json_encode(array(&#39;result&#39;=&gt;true,&#39;msg&#39;=&gt;&#39;Thank you for your purchase!&#39;,&#39;orderId&#39;=&gt;$orderId));
            die();
        }else{
            header(&#39;Content-type: application/json&#39;);
            echo json_encode(array(&#39;result&#39;=&gt;false,&#39;msg&#39;=&gt;&#39;We can\&#39;t validate your payment&#39;));
            die();
        }
    }else{
        header(&#39;Content-type: application/json&#39;);
        echo json_encode(array(&#39;result&#39;=&gt;false,&#39;msg&#39;=&gt;&#39;transactionId is required&#39;));
        die();
    }</code></pre>
                </div>

                <p style="text-align: left">
                    Any issues contact: <a href="mailto:support@cryptocheckout.co" target="_blank">support@cryptocheckout.co</a>
                </p>
                <br />

            </div>
            <script>
                jQuery(function($) {});
            </script>

        </body>
        <footer>
            <div id="footer-container">
                <ul id="footer-list">
                    <li id="footer-terms">
                        <p style="text-align: center;display: inline-block;">
                            <a href="https://cryptocheckout.co/terms" >Terms of Service</a>
                        </p>
                    </li>
                    <li id="privacy-policy">
                    <p style="text-align: center;display: inline-block;">
                            <a href="https://cryptocheckout.co/privacy-policy" >Privacy Policy</a>
                        </p>
                    </li>
                </ul>
            </div>
            <script>
                (function($) {
                    $('#footer-list').css({'list-style': 'none', 'display': 'flex', 'position': 'relative', 'margin-right': 'auto', 'margin-left': 'auto', 'width': '28%', 'padding':'0'});                    
                    $('#privacy-policy').css({'position':'relative','left':'4px'});

                    if (/Android|iPhone|webOS|Opera Mini|iPad|iPod/i.test(navigator.userAgent) ) {
                        $('#footer-container p').css({'font-size':'64px'});
                        $('#footer-list').css({'width':'100%'})

                        //$('#api').css('width', '100%');
                        /*('#codeblock0,#codeblock1,#codeblock2,#codeblock3,#codeblock4,#codeblock5').css({'overflow-y':'scroll','width':'100%'});
                        $('#codeblock5 code').css('width','2000px');
                        $('#codeblock4 code').css('width','1300px');
                        $('#codeblock3 code').css('width','2000px');
                        $('code').css('font-size','21px');*/
                        $('#logo').css({'position':'relative','margin-left':'auto','margin-right':'auto'});
                        $('#spanlogo').css({'background-image':'url("https://cryptocheckout.co/cryptocheckout-m.png")','width':'200px','height':'200px'});
                        $('#logotext').hide();
                        $('#menu').css({'background-color':'white','position':'fixed','height':'200px','min-height':'200px'});
                        //$('#p2').html("2- Initiate button by calling showbtn(div:string,amount:object, <br/> onApprove=function(transactionId){},onError=function(error){}), let our product/service cost 1$ market price:");
                        $('#test5 h4,#test6 h4, #test7 h4, #api h2').css('font-size', '42px');
                        $('#api p,#test2 label').css('font-size', '36px');
                        $('code').css('font-size', '36px');
                        
                        
                        $('#allicon').css({
                            'left': '120px', 'bottom': '60px'
                        });
                        $('#menu').css({
                            'font-size': '28px'
                        });
                        $('#woo').css('top', '50px')
                        $('#pap').css('top', '50px')
                    $('#greeting label,#greeting p,#greeting li').css('font-size', '58px');
                    $('#test2 input').css({'height':'150px'});
                    $('#greeting ul').css({'display': 'block','left':'unset'});
                    $('#test7 h4,#test5 h4,#test6 h4,#api h2').css({'font-size':'100px'});
                    $('#test5,#test6,#test7').css('width','90%');
                    $('th,td').css({'font-size':'58px'});
                    $('#test6').css({'padding-bottom':'150px'});
                    $('.status_round').css({'background-image': 'url("https://cryptocheckout.co/check-m.png")','width':'64px','height':'64px'});
                    }else{
                        $('#test7 h4,#test5 h4,#test6 h4,#api h2').css({'font-size':'48px'});
                        $('#api code').css('font-size','18px');
                        $('#test5').css('width', '51%');
                    }
                    $('html,body').css('overflow-x', 'hidden');
                    $('#api').css('width', '95%');
                    if ($(window).width() <= 1000) {
                        //$('#greeting, #container, #test, #api, .welcom').css('width', '95%');
                        //$('#ip').css('width','100%');
                        $('#container').css('margin-top', '100px');
                        //$('#uploader').css('margin-top','-50px');
                        //$('#clicktoupload').css('top','200px');
                    }
                   $('#test7').hide();
                })(jQuery);
            </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
            <!-- and it's easy to individually load additional languages -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/php.min.js"></script>
            <script>
                hljs.highlightAll();
            </script>
        </footer>
    </html>
    <?php
} else {
    //header('Location: https://cryptocheckout.co/cgi-sys/suspendedpage.cgi');
}