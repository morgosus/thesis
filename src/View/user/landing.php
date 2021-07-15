<div class="account-page">
    <form method="POST">
        <input type="submit" name="logout" value="Odhlásit"/>
    </form>
    
    <form method="POST">
        <label for="newPassword">Změna hesla</label>
        <input type="password" name="newPassword" placeholder="Nové heslo - poprvé" required/>
        <input type="password" name="newPasswordCheck" placeholder="Nové heslo - znovu" required/>
        <label for="newPassword">Old password</label>
        <input type="password" name="oldPassword" placeholder="Staré heslo" required/>
        <input type="submit" name="changePassword" value="Změň"/>
    </form>
    
    <form method="POST">
        <label for="newEmail">Změna emailu</label>
        <input type="email" name="newEmail" placeholder="Nový email" required/>
        <input type="submit" class="submit" name="changeEmail" value="Změň"/>
    </form>
    
    <div class="account-disclaimer">
        V rámci direkcí EU 2016/679 si můžete vyžádat / odstranit svá data. Pokud chcete toto právo uplatnit, kontaktujte mě (viz. kontakt v privacy policy).
        <br>Také si můžete smazat svůj účet v rámci práva na zapomenutí tlačítkem dole.
    </div>
</div>