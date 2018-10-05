<?php

namespace Qck\App\Html;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class LoginForm implements \Qck\App\Interfaces\Html\Template
{

  public function renderHtml()
  {
    ob_start();
    ?>
    <form action="<?= $this->Action ?>">
      <?= $this->FormHeader ? $this->FormHeader->renderHtml() : "" ?>

      <label for="<?= $this->UserNameElement->getId() ?>"><?= $this->UserNameElement->getLabel() ?></label>

      <?= $this->UserNameElement->renderHtml() ?>


      <label for="<?= $this->PasswordElement->getId() ?>"><?= $this->PasswordElement->getLabel() ?></label>

      <?= $this->PasswordElement->renderHtml() ?>
      <?= $this->RememberMeFormElement ? $this->RememberMeFormElement->renderHtml() : "" ?>
      
      <button type="submit">Login</button>
      
    </div>

    </form>
    <?php
    return ob_get_clean();
  }

  // REQUIRED
  /**
   *
   * @var string
   */
  protected $Action;

  /**
   *
   * @var \Qck\App\Interfaces\Html\FormElement
   */
  protected $UserNameElement;

  /**
   *
   * @var \Qck\App\Interfaces\Html\FormElement
   */
  protected $PasswordElement;
  // OPTIONAL
  /**
   *
   * @var \Qck\App\Interfaces\Html\Template
   */
  protected $FormHeader;

  /**
   *
   * @var \Qck\App\Interfaces\Html\FormElement
   */
  protected $RememberMeFormElement;

}
