<?php declare(strict_types=1); ?>

<?php function drawContactSection() { ?>
    <section id="contacts">
        <h1>Recent contacts</h1>
        <ul>
        <?php
        $db = new PDO("sqlite:" . DB_PATH);
        $contacts = Message::getRecentContacts($db, User::getUserByID($db, $_SESSION['user_id']));

        foreach ($contacts as $contact) { 
            $user = User::getUserByID($db, $contact['sender']);
            ?>
            <li id="contact-side">
                <a href="/profile?id=<?= $user->id ?>">
                    <img src="<?= $user->profilePicture->url ?>" width="40" height="40" class="avatar">
                </a>
                <?= $user->name ?>
            </li>            
        <?php
        }
        ?>
        </ul>
    </section>
<?php } ?>


<?php function drawChatSection() { ?>
    <?php 
        $otherUserID = 6;
        $db = new PDO("sqlite:" . DB_PATH);
        $otherUser = User::getUserByID($db, $otherUserID);    
    ?>
    <section id="chat">
        <div id="contact">
            <a href="/profile?id=<?= $otherUser->id ?>">
                <img src="<?= $otherUser->profilePicture->url?>" width="40" height="40" class="avatar">
            </a>
            <?= $otherUser->name ?>
        </div>

        <div id="messages">
            <?php
            $db = new PDO("sqlite:" . DB_PATH);
            $messages = Message::getMessages($db, User::getUserByID($db, $_SESSION['user_id']), $otherUser);
            
            foreach ($messages as $message) {
                if ($message['sender'] == $_SESSION['user_id']) {?>
                    <p class="message user1"><?= $message['content'] ?></p>
                <?php } else { ?>
                    <p class="message user2"><?= $message['content'] ?></p>
                <?php }
            }
            ?>

        </div>

        <div id="writemessage">
            <input type="text" id="newmessage" name="newmessage" placeholder="Type your text here...">
            <input type="button" id="sendbutton" value="Send">
        </div>
    </section>
<?php } ?>

