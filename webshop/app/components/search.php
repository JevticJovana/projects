<div class="search-container">
    <form class="search-form" action="../public/search_results.php" method="get">
        <input type="text" class="search-input shadow-custom" name = "search_text" placeholder="Unesite naziv proizvoda, kategoriju..." value = "<?php if(isset($_GET['search_text'])) echo $_GET['search_text'];?>">
        <button type="submit" class="search-button shadow-custom">Pretrazi</button>
    </form>
</div>