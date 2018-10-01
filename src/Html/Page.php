<?php

namespace Qck\App\Html;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class Page implements \Qck\App\Interfaces\Html\Page
{

  function __construct( $Title, $BodyTemplateOrText,
                        \Qck\App\Interfaces\LanguageProvider $LanguageProvider = null )
  {
    $this->Title = $Title;
    $this->BodyTemplateOrText = $BodyTemplateOrText;
    $this->LanguageProvider = $LanguageProvider;
  }

  public function addCssLink( $href, $integrity = null, $crossOrigin = null )
  {
    $this->CssLinks = [ $href, $integrity, $crossOrigin ];
  }

  public function addJavaScript( $src, $integrity = null, $crossOrigin = null,
                                 $PlaceBeforeBodyEndTag = true )
  {
    $this->Scripts = [ $src, $integrity, $crossOrigin, $PlaceBeforeBodyEndTag ];
  }

  public function getAdditionalHeaders()
  {
    return [];
  }

  public function getCharset()
  {
    return \Qck\App\Interfaces\Output::CHARSET_UTF_8;
  }

  public function getContentType()
  {
    return \Qck\App\Interfaces\Output::CONTENT_TYPE_TEXT_HTML;
  }

  public function render()
  {
    return $this->renderHtml();
  }

  public function renderHtml()
  {
    ob_start();
    $lang = $this->printAttributeIfSet( "lang", $this->LanguageProvider ? $this->LanguageProvider->get() : null );
    ?>
    <!doctype html>
    <html<?= $lang ?>>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php
        foreach ( $this->CssLinks as $CssLink ):
          $integrity = $this->printAttributeIfSet( "integrity", $CssLink[ 1 ] );
          $crossorigin = $this->printAttributeIfSet( "crossorigin", $CssLink[ 2 ] );
          ?>
          <link rel="stylesheet" href="<?= $CssLink[ 0 ] ?>"<?= $integrity . $crossorigin ?>>
        <?php endforeach; ?>


        <title><?= $this->Title ?></title>
      </head>
      <body>
        <?= is_string( $this->BodyTemplateOrText ) ? $this->BodyTemplateOrText : $this->BodyTemplateOrText->renderHtml() ?>

        <?php
        foreach ( $this->Scripts as $Script ):
          $integrity = $this->printAttributeIfSet( "integrity", $Script[ 1 ] );
          $crossorigin = $this->printAttributeIfSet( "crossorigin", $Script[ 2 ] );
          ?>
          <script src="<?= $Script[ 0 ] ?>"<?= $integrity . $crossorigin ?>></script>        
        <?php endforeach; ?>

      </body>
    </html>
    <?php
    return ob_get_clean();
  }

  protected function printAttributeIfSet( $attName, $attValue, $addPrependingSpace = true )
  {
    echo is_null( $attValue ) ? "" : ($addPrependingSpace ? " " : "") . $attName . '="' . $attValue . '"';
  }

  /**
   *
   * @var string
   */
  protected $Title;

  /**
   *
   * @var mixed
   */
  protected $BodyTemplateOrText;

  /**
   *
   * @var \Qck\App\Interfaces\LanguageProvider
   */
  protected $LanguageProvider;

  /**
   *
   * @var array
   */
  protected $CssLinks = [];

  /**
   *
   * @var array
   */
  protected $Scripts = [];

}
