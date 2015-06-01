<?php
if( !defined( 'ADMIN_PAGE' ) )
  exit;
?>
  <footer id="foot">
    <nav>
      <ul>
        <li class="back"><a href="javascript:history.back();">&laquo; <?php echo $lang['back']; ?></a></li>
        <li class="home"><a href="./" target="_blank"><?php echo $lang['homepage']; ?></a></li>
      </ul>
    </nav>
  </footer>
</div>
<?php
if( isset( $_COOKIE['bLicense'.str_replace( '.', '', $config['version'] )] ) && !isset( $_COOKIE['bNoticesDisplayed'] ) && isset( $_SESSION['iMessagesNoticesNumber'] ) && $_SESSION['iMessagesNoticesNumber'] > 0 ){ ?>
  <script>
  $(function(){
    $( '#messages .notices > a:first-child' ).trigger( 'click' );
    createCookie( 'bNoticesDisplayed', 1 );
  });
  </script><?php
} ?>
  <div class="msg ext-features">
    <?php if( $config['admin_lang'] == 'pl' ){ echo '<p>Tą i wiele innych opcji znajdziesz w <a href="http://opensolution.org/?p=Quick.Cms.Ext" target="_blank">Quick.Cms.Ext &raquo;</a>.</p><div class="buttons"><a href="?p=plugins" target="_blank">Zobacz dodatki dla Quick.Cms.Ext &raquo;</a></div>'; } else{ echo '<p>This and many other features are available in <a href="http://opensolution.org/?p=Quick.Cms.Ext" target="_blank">Quick.Cms.Ext &raquo;</a>.</p><div class="buttons"><a href="?p=plugins" target="_blank">Check plugins for Quick.Cms.Ext &raquo;</a></div>'; } ?>
  </div>
</body>
</html>