<?php
function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function formatear(float $numero): string
{
    $texto = number_format(round($numero, 8), 8, '.', '');
    $texto = rtrim(rtrim($texto, '0'), '.');
    return ($texto === '-0' || $texto === '') ? '0' : $texto;
}

$operaciones = [
    'sumar'       => ['nombre' => 'Sumar (+)',                    'simbolo' => '+'],
    'restar'      => ['nombre' => 'Restar (−)',                   'simbolo' => '−'],
    'multiplicar' => ['nombre' => 'Multiplicar (×)',              'simbolo' => '×'],
    'dividir'     => ['nombre' => 'Dividir (÷)',                  'simbolo' => '÷'],
    'potencia'    => ['nombre' => 'Potencia (a elevado a b)',     'simbolo' => '^'],
    'raiz'        => ['nombre' => 'Raíz (raíz b-ésima de a)',     'simbolo' => '√'],
    'modulo'      => ['nombre' => 'Módulo (residuo de a ÷ b)',    'simbolo' => 'mod'],
    'porcentaje'  => ['nombre' => 'Porcentaje (b % de a)',        'simbolo' => '%'],
];

$numeroA = '';
$numeroB = '';
$operacion = 'sumar';
$resultado = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeroA = is_string($_POST['numero_a'] ?? null) ? trim($_POST['numero_a']) : '';
    $numeroB = is_string($_POST['numero_b'] ?? null) ? trim($_POST['numero_b']) : '';
    $operacion = is_string($_POST['operacion'] ?? null) ? $_POST['operacion'] : '';

    if ($numeroA === '' || $numeroB === '') {
        $error = 'Escribe los dos números para hacer el cálculo.';
    } elseif (!is_numeric($numeroA) || !is_numeric($numeroB)) {
        $error = 'Escribe números válidos. Para los decimales, usa un punto.';
    } elseif (!isset($operaciones[$operacion])) {
        $error = 'Selecciona una operación válida.';
    } else {
        $a = (float) $numeroA;
        $b = (float) $numeroB;

        if (!is_finite($a) || !is_finite($b)) {
            $error = 'Los números ingresados son demasiado grandes.';
        } else {
            switch ($operacion) {
                case 'sumar':
                    $resultado = $a + $b;
                    break;
                case 'restar':
                    $resultado = $a - $b;
                    break;
                case 'multiplicar':
                    $resultado = $a * $b;
                    break;
                case 'dividir':
                    if ($b == 0) {
                        $error = 'No se puede dividir entre cero.';
                    } else {
                        $resultado = $a / $b;
                    }
                    break;
                case 'potencia':
                    $resultado = pow($a, $b);
                    break;
                case 'raiz':
                    if ($b <= 0) {
                        $error = 'El índice de la raíz debe ser mayor que cero.';
                    } elseif ($a < 0) {
                        $error = 'No se puede calcular la raíz de un número negativo.';
                    } else {
                        $resultado = pow($a, 1 / $b);
                    }
                    break;
                case 'modulo':
                    if ($b == 0) {
                        $error = 'No se puede calcular el módulo con cero.';
                    } else {
                        $resultado = fmod($a, $b);
                    }
                    break;
                case 'porcentaje':
                    $resultado = $a * $b / 100;
                    break;
            }

            if ($error === '' && ($resultado === null || !is_finite($resultado))) {
                $resultado = null;
                $error = 'El resultado no es un número real o es demasiado grande. Prueba con otros valores.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portafolio académico de Ali Paredes, estudiante de sexto nivel de Ingeniería en Software en UNIANDES. Práctica de Aplicaciones Web con una calculadora en PHP.">
    <title>Ali Paredes | Ingeniería en Software</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a class="saltar" href="#contenido">Ir al contenido</a>

    <header class="cabecera" id="inicio">
        <div class="envoltorio barra">
            <a class="marca" href="#inicio">Ali Paredes<span> · Portafolio académico</span></a>
            <nav aria-label="Navegación principal">
                <a href="#perfil">Perfil</a>
                <a href="#estudios">Estudios</a>
                <a href="#herramientas">Herramientas</a>
                <a href="#practica">Práctica</a>
                <a href="#calculadora">Calculadora</a>
            </nav>
        </div>
    </header>

    <main id="contenido">
        <section class="portada" aria-labelledby="titulo-portada">
            <div class="envoltorio portada-grid">
                <div>
                    <p class="rotulo">UNIANDES · Sexto nivel</p>
                    <h1 id="titulo-portada">Hola, soy Ali Paredes.</h1>
                    <p class="subtitulo">Estudiante en formación como ingeniero de software.</p>
                    <p class="resumen">Me gusta convertir ideas en programas que funcionan y mejorar un poco cada vez que escribo código.</p>
                    <a class="boton" href="#calculadora">Probar la calculadora <span aria-hidden="true">↓</span></a>
                </div>
                <aside class="ficha" aria-label="Datos de la práctica">
                    <h2 class="ficha-titulo">Ficha de la práctica</h2>
                    <dl>
                        <div><dt>Universidad</dt><dd>UNIANDES</dd></div>
                        <div><dt>Nivel</dt><dd>Sexto</dd></div>
                        <div><dt>Materia</dt><dd>Aplicaciones Web</dd></div>
                        <div><dt>Docente</dt><dd>Ing. Luis Llerena</dd></div>
                        <div><dt>Tema</dt><dd>HTML, CSS y PHP</dd></div>
                    </dl>
                </aside>
            </div>
        </section>

        <div class="envoltorio">
            <section class="bloque dos-columnas" id="perfil" aria-labelledby="titulo-perfil">
                <div>
                    <p class="numero">01 · Perfil</p>
                    <h2 id="titulo-perfil">Sobre mí</h2>
                </div>
                <div>
                    <p>Soy Ali Paredes y curso el sexto nivel de Ingeniería en Software en la Universidad Regional Autónoma de los Andes (UNIANDES). Me interesa la programación y entender cómo se construye una aplicación desde la idea hasta que alguien la usa.</p>
                    <p>En esta página practico la estructura con HTML, el diseño con CSS y el procesamiento de datos en el servidor con PHP.</p>
                </div>
            </section>

            <section class="bloque dos-columnas" id="estudios" aria-labelledby="titulo-estudios">
                <div>
                    <p class="numero">02 · Estudios</p>
                    <h2 id="titulo-estudios">Formación académica</h2>
                </div>
                <div class="linea-estudio">
                    <h3>Ingeniería en Software</h3>
                    <p>Universidad Regional Autónoma de los Andes (UNIANDES) · Sexto nivel</p>
                    <p class="nota">Práctica de la materia Aplicaciones Web, a cargo del Ing. Luis Llerena.</p>
                </div>
            </section>

            <section class="bloque" id="herramientas" aria-labelledby="titulo-herramientas">
                <p class="numero">03 · Herramientas</p>
                <h2 id="titulo-herramientas">Lo que uso en esta práctica</h2>
                <ul class="tarjetas">
                    <li>
                        <h3>HTML5</h3>
                        <p>Secciones semánticas, listas de datos y formularios accesibles.</p>
                    </li>
                    <li>
                        <h3>CSS3</h3>
                        <p>Variables, cuadrículas y diseño adaptable a celulares.</p>
                    </li>
                    <li>
                        <h3>PHP</h3>
                        <p>Operaciones aritméticas, condicionales y validación de los datos enviados.</p>
                    </li>
                    <li>
                        <h3>Entorno</h3>
                        <p>Visual Studio Code y XAMPP para probar el sitio en local.</p>
                    </li>
                </ul>
            </section>

            <section class="bloque" id="practica" aria-labelledby="titulo-practica">
                <p class="numero">04 · Práctica</p>
                <h2 id="titulo-practica">Proyecto académico</h2>
                <article class="proyecto">
                    <div>
                        <p class="estado">Práctica actual · Aplicaciones Web</p>
                        <h3>Página personal con calculadora</h3>
                        <p>Una página personal con mi información académica que incluye una calculadora de ocho operaciones. Los datos se envían al servidor y PHP los valida antes de calcular.</p>
                        <p class="tecnologias">HTML5 · CSS3 · PHP</p>
                    </div>
                    <a class="enlace" href="#calculadora">Ir a la calculadora →</a>
                </article>
            </section>

            <section class="bloque dos-columnas" id="calculadora" aria-labelledby="titulo-calculadora">
                <div>
                    <p class="numero">05 · Programa en PHP</p>
                    <h2 id="titulo-calculadora">Calculadora</h2>
                    <p>Escribe dos números, elige la operación y presiona calcular. El resultado se muestra en este mismo lugar.</p>
                    <p class="ayuda">Puedes usar números negativos y decimales. Para escribir un decimal, usa un punto; por ejemplo, 2.5.</p>
                    <ul class="formulas" aria-label="Operaciones disponibles">
                        <li><strong>Potencia:</strong> a elevado a b</li>
                        <li><strong>Raíz:</strong> raíz b-ésima de a (b = 2 es la raíz cuadrada)</li>
                        <li><strong>Módulo:</strong> residuo de dividir a entre b</li>
                        <li><strong>Porcentaje:</strong> el b % de a</li>
                    </ul>
                </div>
                <form class="formulario" action="#calculadora" method="post">
                    <div class="par">
                        <div>
                            <label for="numero-a">Número a</label>
                            <input type="number" id="numero-a" name="numero_a" step="any" placeholder="Ej. 12" value="<?= escapar($numeroA) ?>" required>
                        </div>
                        <div>
                            <label for="numero-b">Número b</label>
                            <input type="number" id="numero-b" name="numero_b" step="any" placeholder="Ej. 4" value="<?= escapar($numeroB) ?>" required>
                        </div>
                    </div>

                    <label for="operacion">Operación</label>
                    <select id="operacion" name="operacion" required>
                        <?php if (!isset($operaciones[$operacion])): ?>
                            <option value="" selected disabled>Selecciona una operación válida</option>
                        <?php endif; ?>
                        <?php foreach ($operaciones as $clave => $datos): ?>
                            <option value="<?= escapar($clave) ?>" <?= $operacion === $clave ? 'selected' : '' ?>><?= escapar($datos['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button class="boton boton-ancho" type="submit">Calcular</button>

                    <div class="respuesta" aria-live="polite" aria-atomic="true">
                        <?php if ($error !== ''): ?>
                            <p class="error" role="alert"><?= escapar($error) ?></p>
                        <?php elseif ($resultado !== null): ?>
                            <p class="rotulo-resultado">Resultado</p>
                            <p class="resultado"><output><?= escapar(formatear($resultado)) ?></output></p>
                            <p class="detalle"><?= escapar($numeroA) ?> <?= escapar($operaciones[$operacion]['simbolo']) ?> <?= escapar($numeroB) ?></p>
                        <?php else: ?>
                            <p class="ayuda">Aquí aparecerá el resultado de tu operación.</p>
                        <?php endif; ?>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <footer class="pie">
        <div class="envoltorio pie-grid">
            <p><strong>Ali Paredes</strong> · Ingeniería en Software</p>
            <p>UNIANDES · Aplicaciones Web · Sexto nivel</p>
        </div>
    </footer>
</body>
</html>
