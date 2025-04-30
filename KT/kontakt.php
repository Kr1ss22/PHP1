<h2>Kontaktivorm</h2>
<form action="send_message.php" method="POST">
    <label for="name">Nimi:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="email">E-post:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="message">Sõnum:</label>
    <textarea id="message" name="message" required></textarea>
    
    <button type="submit">Saada sõnum</button>
</form>

<a href="index1.php" class="btn btn-secondary">Tagasi Avalehele</a>