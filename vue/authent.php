<div class="menu">
  <h4>Authentification</h4>
  <form method="post" action="index.php">
    <input type="hidden" name="action" value="authent" />
    <table width="100%" border="0" cellspacing="2">
      <tr>
        <td class="auth">login </td>
        <td>
          <input type="text" id ="login" name="login" size="10" maxlength="64" />
        </td>
      </tr>
      <tr>
        <td class="auth">code </td>
        <td>
          <input type="password" name="mdp" size="10" maxlength="12" />
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div class="centrer">
            <input type="submit" name="envoi" value="Envoi" />
          </div>
        </td>
      </tr>
    </table>

  </form>

  <script language="javascript">
    document.getElementById('login').focus();
  </script>
</div>
