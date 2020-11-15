<?php

require_once "Buttons.php";

function PrintArticle(
  $id, 
  $printEdit, 
  $photoPath, 
  $title, 
  $text, 
  $titleSize = "1.5rem", 
  $textSize = "1rem", 
  $textColor = "black", 
  $border="none"
  ) {
  return "
    <div class='card' style='border: ".$border."'>
      <img src='/imgs/".$photoPath."' class='card-img-top' alt='Пост' />
    
      <div class='card-body'>

        <h5 class='cart-title' style='font-size:".$titleSize.";'>
          ".$title."
        </h5>

        <p class='card-text' style='font-size:".$textSize."; color:".$textColor.";'>
          ".$text."
        </p>

        <div>
          ".($printEdit ? PrintEditButton($id) : '')."
          ".PrintDetailedButton($id)."
        </div>
      </div>

    </div>
  ";
} 

function PrintDetailedArticle(
  $title,
  $text,
  $created_time,
  $photo
) {
  return "
  <div>

    <div>
      <img src='/imgs/".$photo."' />
    </div>

    <div>
      <h1>".$title."</h1>
    </div>

    <div>
      ".$created_time."
    </div>

    <div style='word-wrap:break-word;'>
      ".$text."
    </div>

  </div>
  ";
}
