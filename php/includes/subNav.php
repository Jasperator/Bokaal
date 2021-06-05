<?php

include_once(__DIR__ . "/bootstrap.include.php");



//Put the pagename in a variable
//PHP_SELF returns the path, basename shortens it to the filename
$page = basename($_SERVER['PHP_SELF']);


?>

<div class="subMenu" >
    <a href="favor.php"><img  <?php if ($page == "favor.php") : echo "active";?> class="activated subIcon" <?php endif; ?> class="subIcon" src="../../images/icon/star.png" alt=""></a>
    <a href="chat.php"><img <?php if ($page == "chat.php") : echo "active";?> class="activated subIcon" <?php endif; ?> class="subIcon" src="../../images/icon/messenger.png" alt=""></a>
    <a href="bought.php"><img  <?php if ($page == "bought.php") : echo "active";?> class="activated subIcon" <?php endif; ?> class="subIcon" src="../../images/icon/dollar.png" alt=""></a>
    <a href="settings.php"><img  <?php if ($page == "settings.php") : echo "active";?> class="activated subIcon" <?php endif; ?> class="subIcon" src="../../images/icon/setting.png" alt=""></a>
  </div>