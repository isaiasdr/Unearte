<?php 
	function pow2($x, $n) {

		if (is_numeric($x) && is_int($n)) {

			if ($x < -100 || $x > 100) {
				exit('El valor ingresado de "x" esta fuera del rango aceptado');
			} elseif ($n <= PHP_INT_MIN || $n >= PHP_INT_MAX) {
				exit('El valor ingresado de "n" esta fuera del rango aceptado');
			} else {

				$sol= 1;

				if($n==0) {
					return 1;

				} elseif($n > 0) {

					for ($i=0; $i < $n ; $i++) { 
						//precision de 4 valores decimales
						$sol= round($sol * $x, 4);

					}
					return $sol;

				} else {

					for ($i=0; $i < $n; $i++) { 
						//precision de 4 valores decimales
						$sol= round($sol / $x, 4); 
					}

				}
				return $sol;
			}
		}
		echo 'El valor "x" o "n" no es entero, intente nuevamente';
	}

	echo "\n\n";
	echo "Ejemplo 1";
	echo "\n";
	echo pow2(2, 10);

	echo "\n\n";
	echo "Ejemplo 2";
	echo "\n";
	echo pow2(2.10000, 3);

	echo "\n\n";
	echo "Ejemplo 3";
	echo "\n\n";
	echo pow2(2.00000, -2);


?>