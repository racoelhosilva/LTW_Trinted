<?php declare(strict_types=1);

include_once __DIR__ . '/../actions/utils.php';
?>

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
            <li class="contact-side" data-user-id="<?= $user->id ?>">
                <img src="<?= $user->profilePicture->url ?>" width="40" height="40" class="avatar contact-avatar">
                <?= $user->name ?>
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
                $timeDiff = dateFormat($message['datetime']);
                if ($message['sender'] == $_SESSION['user_id']) {?>
                    <div class="message user1" data-message-id="<?= $message['id'] ?>">
                        <p><?= $message['content'] ?></p>
                        <p><?= $timeDiff ?></p>
                    </div>
                <?php } else { ?>
                    <div class="message user2" data-message-id="<?= $message['id'] ?>">
                        <p><?= $message['content'] ?></p>
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

