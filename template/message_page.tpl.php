<?php declare(strict_types=1); ?>

<?php function drawContactSection() { ?>
    <section id="contacts">
        <h1>Recent contacts</h1>
        <ul>
        <li>
            <img src="https://picsum.photos/seed/picsum/200/" width="40" height="40" class="avatar">
            Vasco Palmeirim
        </li>
        <li>
            <img src="https://picsum.photos/seed/picsum/200/" width="40" height="40" class="avatar">
            Vasco Palmeirim
        </li>
        <li>
            <img src="https://picsum.photos/seed/picsum/200/" width="40" height="40" class="avatar">
            Vasco Palmeirim
        </li>
        <li>
            <img src="https://picsum.photos/seed/picsum/200/" width="40" height="40" class="avatar">
            Vasco Palmeirim
        </li>
        </ul>
    </section>
<?php } ?>


<?php function drawChatSection() { ?>
    <section id="chat">
        <div id="contact">
            <img src="https://picsum.photos/seed/picsum/200/" width="40" height="40" class="avatar">
            Vasco Palmeirim
        </div>

        <div id="messages">
            <div>
        </div>

        <div id="writemessage">
            <input type="text" id="newmessage" name="newmessage" placeholder="Type your text here...">
            <input type="submit" value="Send">
        </div>
    </section>
<?php } ?>

