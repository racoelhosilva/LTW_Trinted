<?php
declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
?>

<?php function drawTermsAndConditionsContent()
{ ?>
    <main id="about-page">
        <h1>Terms and Conditions</h1>
        <section>
            <h2>Welcome to Trinted!</h2>
            <p>These terms and conditions outline the rules and regulations for the use of Trinted LLC's Website,
                located at trinted.com.
            </p>
            <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use Trinted
                if you do not agree to take all of the terms and conditions stated on this page.
            <p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice
                and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and
                compliant to the Company's terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us",
                refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms
                refer to the offer, acceptance and consideration of payment necessary to undertake the process of our
                assistance to the Client in the most appropriate manner for the express purpose of meeting the Client's
                needs in respect of provision of the Company's stated services, in accordance with and subject to,
                prevailing law of pt. Any use of the above terminology or other words in the singular, plural,
                capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
        </section>
        <section>
            <h2>Cookies</h2>
            <p>We employ the use of cookies. By accessing Trinted, you agreed to use cookies in agreement with the
                Trinted
                LLC's Privacy Policy.
            </p>
            <p>Most interactive websites use cookies to let us retrieve the user's details for each visit. Cookies are
                used by our website to enable the functionality of certain areas to make it easier for people visiting
                our website. Some of our affiliate/advertising partners may also use cookies.
            </p>
        </section>
        <section>
            <h2>License</h2>
            <p>Unless otherwise stated, Trinted LLC and/or its licensors own the intellectual property rights for all
                material on Trinted. All intellectual property rights are reserved. You may access this from Trinted for
                your own personal use subjected to restrictions set in these terms and conditions.
            </p>
            <p>You must not:</p>
            <ul>
                <li>Republish material from Trinted</li>
                <li>Sell, rent or sub-license material from Trinted</li>
                <li>Reproduce, duplicate or copy material from Trinted</li>
                <li>Redistribute content from Trinted</li>
            </ul>
            <p>This Agreement shall begin on the date hereof.</p>
            <p>Trinted LLC reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.
            </p>
        </section>
    </main>
<?php } ?>

<?php
function drawTermsAndConditionsPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawTermsAndConditionsContent($request);
        drawFooter();
    }, $request);
} ?>