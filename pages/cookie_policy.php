<?php
declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
?>

<?php function drawCookiePolicyContent()
{ ?>
    <main id="about-page">
        <h1>This is the Cookie Policy for Trinted</h1>
        <section>
            <h2>What Are Cookies</h2>
            <p>As is common practice with almost all professional websites this site uses cookies, which are tiny files
                that are downloaded to your computer, to improve your experience. This page describes what information
                they gather, how we use it and why we sometimes need to store these cookies. We will also share how you
                can prevent these cookies from being stored however this may downgrade or 'break' certain elements of
                the sites functionality.
            </p>
        </section>
        <section>
            <h2>How We Use Cookies</h2>
            <p>We use cookies for a variety of reasons detailed below. Unfortunately in most cases there are no industry
                standard options for disabling cookies without completely disabling the functionality and features they
                add to this site. It is recommended that you leave on all cookies if you are not sure whether you need
                them or not in case they are used to provide a service that you use.
            </p>
        </section>
        <section>
            <h2>Disabling Cookies</h2>
            <p>You can prevent the setting of cookies by adjusting the settings on your browser (see your browser Help
                for how to do this). Be aware that disabling cookies will affect the functionality of this and many
                other websites that you visit. Disabling cookies will usually result in also disabling certain
                functionality and features of the this site. Therefore it is recommended that you do not disable
                cookies. This Cookies Policy was created with the help of the Cookies Policy Generator.
            </p>
        </section>
        <section>
            <h2>Account related cookies</h2>
            <p>If you create an account with us then we will use cookies for the management of the signup process and
                general administration. These cookies will usually be deleted when you log out however in some cases
                they may remain afterwards to remember your site preferences when logged out.
            </p>
        </section>
        <section>
            <h2>Login related cookies</h2>
            <p>We use cookies when you are logged in so that we can remember this fact. This prevents you from having to
                log in every single time you visit a new page. These cookies are typically removed or cleared when you
                log out to ensure that you can only access restricted features and areas when logged in.
            </p>
        </section>
        <section>
            <h2>Orders processing related cookies</h2>
            <p>This site offers e-commerce or payment facilities and some cookies are essential to ensure that your
                order is remembered between pages so that we can process it properly.
            </p>
        </section>
        <section>
            <h2>Site preferences cookies</h2>
            <p>In order to provide you with a great experience on this site we provide the functionality to set your
                preferences for how this site runs when you use it. In order to remember your preferences we need to set
                cookies so that this information can be called whenever you interact with a page is affected by your
                preferences.
            </p>
        </section>
        <section>
            <h2>Third Party Cookies</h2>
            <p>In some special cases we also use cookies provided by trusted third parties. The following section
                details which third party cookies you might encounter through this site.
                From time to time we test new features and make subtle changes to the way that the site is delivered.
                When we are still testing new features these cookies may be used to ensure that you receive a consistent
                experience whilst on the site whilst ensuring we understand which optimisations our users appreciate the
                most.
            </p>
        </section>
        <section>
            <h2>More Information</h2>
            <p>Hopefully that has clarified things for you and as was previously mentioned if there is something that
                you aren't sure whether you need or not it's usually safer to leave cookies enabled in case it does
                interact with one of the features you use on our site.
                For more general information on cookies, please read the Cookies Policy article.
                However if you are still looking for more information then you can contact us through one of our
                preferred contact methods:
                Email: wewillnotrespond@trinted.com</p>
        </section>2
    </main>
<?php } ?>

<?php
function drawCookiePolicyPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawCookiePolicyContent($request);
        drawFooter();
    }, $request);
} ?>