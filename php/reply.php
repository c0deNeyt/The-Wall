        <div class='reply'>
  <?=  getAllReplies($rId);?>
          <form method="post" action="php/process.php">
              <input type='hidden' name='replyAction' value='send'>
<?="              <input type='hidden' name='replyId' value='".$rId."'>"."\r\n";?>
              <input class='reply' type='text' name='composedReply' placeholder='Reply...'>
              <input class='replyBtn' type="submit" value='Reply'>
          </form>
        </div>