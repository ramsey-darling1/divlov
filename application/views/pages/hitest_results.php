<div id="hitest_results">
    <?php
        if(isset($correct)){
            echo "<h2>You got {$correct} right.</h2>";
        }
        if(isset($percent)){
            echo "<h3>That's {$percent}% correct.</h3>";
        }
        
    ?>
</div>
