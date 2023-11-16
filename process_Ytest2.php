<?php

function generateFoodOptions($category)
{
    $foods = array("음식1", "음식2", "음식3", "음식4", "음식5", "음식6", "음식7", "음식8", "음식9", "음식10");

    foreach ($foods as $food) {
        echo '<label>' . $food . ': </label>';
        echo '<select name="' . $category . '[' . $food . ']">';
        echo '<option value="못 먹어요">못 먹어요</option>';
        echo '<option value="싫어요">싫어요</option>';
        echo '<option value="보통이에요">보통이에요</option>';
        echo '<option value="좋아요">좋아요</option>';
        echo '<option value="매우 좋아요">매우 좋아요</option>';
        echo '</select><br>';
    }
}

?>
