<?php

namespace App\ArquivosLayout;

/**
 * Contém método para ser utilizado em Models do Eloquent.
 * O método construtor desabilita o EventDispatcher do modelo em questão.
 */
trait DesabilitarEventDispatcher
{
	function __construct() {

		// Desabilitando o EventDispatcher para evitar que sejam gravados logs
		// do Eloquent durante as importações.
		$this->unsetEventDispatcher();
	}
}
