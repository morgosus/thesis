<?php if ($this->controller->headerAndFooter): ?>
<div id="search-containter">
    <div id="search-wait">
        <div id="search-loading-bar">Loading...</div>
    </div>
    <div id="found"></div>
</div>

<!--Main notification element #notice-paragraph, accessed through JavaScript within btt-and-modes.js
TODO: Localize this-->
<p onclick="this.remove()" title="Click me to remove me." id="notice-paragraph" class="standard-border"></p>
<?php endif; ?>