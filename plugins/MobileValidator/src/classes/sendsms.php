<HTML>
<HEAD><TITLE> SMS sending results </TITLE></HEAD>
<BODY>
    <?php
	require ("SmsInterface.inc");

	echo "<P> Message sent to <B>" . $_POST["phone"] . "</B> ";

	$si = new SmsInterface (false, false);
	$si->addMessage ($_POST["phone"], $_POST["message"]);
	$si->addMessage (null, $_POST["message"]);

	if (!$si->connect ($_POST["username"], $_POST["password"], true, 
false))
	    echo "failed. Could not contact server.\n";
	elseif (!$si->sendMessages ()) {
	    echo "failed. Could not send message to server.\n";
	    if ($si->getResponseMessage () !== NULL)
		echo "<BR>Reason: " . $si->getResponseMessage () . "\n";
	} else
	    echo "OK.\n";
    ?>
</BODY>
</HTML>
