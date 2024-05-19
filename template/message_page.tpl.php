<?php declare(strict_types=1);

require_once __DIR__ . '/../actions/utils.php';
?>

<?php function drawContactSection() { ?>
    <section id="contacts">
        <h1>Recent contacts</h1>
        <ul>
        <?php
        $db = new PDO("sqlite:" . DB_PATH);
        $contacts = Message::getRecentContacts($db, User::getUserByID($db, $_SESSION['user']['id']));

        foreach ($contacts as $contact) { 
            $user = User::getUserByID($db, $contact['sender']);
            ?>
            <li class="contact-side" data-user-id="<?= $user->getId() ?>">
                <img src="<?= $user->getProfilePicture()->getUrl() ?>" width="40" height="40" class="avatar contact-avatar">
                <?= $user->getName() ?>
            </li>            
        <?php
        }
        ?>
        </ul>
    </section>
<?php } ?>


<?php function drawChatSection() { ?>
    <section id="chat">
    <?php 
        if (isset($_GET['id'])) {
        $otherUserID = (int)$_GET['id'];
        $db = new PDO("sqlite:" . DB_PATH);
        $otherUser = User::getUserByID($db, $otherUserID); 
    ?>
        <div id="contact">
            <a href="/profile/<?= $otherUser->getId() ?>">
                <img src="<?= $otherUser->getProfilePicture()->getUrl() ?>" class="avatar">
            </a>
            <?= $otherUser->getName() ?>
        </div>

        <div id="messages">
            <?php
            $db = new PDO("sqlite:" . DB_PATH);
            $messages = Message::getMessages($db, User::getUserByID($db, $_SESSION['user']['id']), $otherUser, PHP_INT_MAX);      

            foreach ($messages as $message) {
                $timeDiff = dateFormat($message->getDatetime());
                if ($message->getSender()->getId() == $_SESSION['user']['id']) {?>
                    <div class="message user1" data-message-id="<?= $message->getId() ?>">
                        <p><?= $message->getContent() ?></p>
                        <p><?= $timeDiff ?></p>
                    </div>
                <?php } else { ?>
                    <div class="message user2" data-message-id="<?= $message->getId() ?>">
                        <p><?= $message->getContent() ?></p>
                        <p><?= $timeDiff ?> </p>                    
                    </div>
                <?php }
            } 
        ?>
        </div>
        <?php } else { ?>
            <div id="contact"></div> 
            <div id="messages"></div>
        <?php } ?>


        <div id="writemessage">
            <input type="text" id="newmessage" name="newmessage" placeholder="Type your text here...">
            <input type="button" id="sendbutton" value="Send">
        </div>
    </section>
<?php } ?>

