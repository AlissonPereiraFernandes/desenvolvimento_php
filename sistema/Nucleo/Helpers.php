<?php

namespace sistema\Nucleo;

use Exception;

class Helpers
{

public static function redirecionar(string $url = null): void
{
    Header('HTTP/1.1 302 Found');

    $local = ($url ? self::url($url) : self::url());

    header("Location: {$local} ");
    exit();
}

public static function limparNumero(string $numero): string
{
    return preg_replace('/[^0-9]/', '', $numero);
}

/**
 * Válidar um número de CPF
 * 
 * @param string $CPF
 * @return bool
 */
public static function validarCpf(string $cpf): bool
{
    $cpf = self::limparNumero($cpf);
    
    if (mb_strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        throw new Exception('O CPF precisa ter 11 digítos!');
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            throw new Exception('CPF válido!');
        }
    }
    return true;
}

/**
 *  Gerar url amigável 
 * @param string $string
 * @return $slug
 */
public static function slug(string $string): string
{
    $map['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?¨|;:.,\\\'<>°ºª  '; 

    $map['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
    $slug = strtr(mb_convert_encoding($string, 'UTF-8', 'UTF-8'), mb_convert_encoding($map['a'], 'UTF-8', 'UTF-8'), $map['b']);
    $slug = strip_tags(trim($slug));
    $slug = str_replace(' ', '-', $slug);
    $slug = str_replace(['-----', '----', '---', '--'], '-', $slug);

    return strtolower(mb_convert_encoding($slug, 'UTF-8', 'UTF-8'));
}

public static function dataAtual(): string
{
    $diaMeses = date('d');
    $diaSemana = date('w');
    $mes = date('n');
    $ano = date('Y');

    $diasDaSemana = [
        "domingo",
        "segunda-feira",
        "terça-feira",
        "quarta-feira",
        "quinta-feira",
        "sexta-feira",
        "sábado"
    ];

    $mesesDoAno = [
        "janeiro",
        "fevereiro",
        "março",
        "abril",
        "maio",
        "junho",
        "julho",
        "agosto",
        "setembro",
        "outubro",
        "novembro",
        "dezembro"
    ];

    $dataFormatada = $diasDaSemana[$diaSemana].' '.$diaMeses. ' de '.$mesesDoAno[$mes].' de '.$ano;

    return $dataFormatada;
}

/**
 * Exibir a url completa filtrando o SERVER_NAME e acrecentando as var globais 
 * 
 * @param string $url
 * @return string
 */
public static function url(string $url = null): string
{
    $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
    $ambiente = ($servidor == 'localhost' ? URL_DESENVOLVIMENTO : URL_PRODUCAO);

    if (str_starts_with($url, '/')) {
        return $ambiente . $url;
    } else {
        return $ambiente . '/' . $url;
    }
}

/**
 * Leitura do SERVER NAME servidor para saber se é localhost ou não 
 * 
 * @return bool
 */
public static function localHost(): bool
{
    $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');

    if ($servidor == 'localhost') {
        return true;
    }
    return false;
}

/**
 * Validação url manual 
 * 
 * @param string $url
 * @return bool
 */
public static function validarUrl(string $url): bool
{
    if (mb_strlen($url) < 10) {
        return false;
    }
    if (!str_contains($url, '.')) {
        return false;
    }
    if (str_contains($url, 'http://') or str_contains($url, 'https://')) {
        return true;
    }
    return false;
}

/**
 * Validação de url
 * 
 * @param string $url
 * @return bool
 */
public static function validarUrlComFiltro(string $url): bool
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Validação de email
 * 
 * @param string $email
 * @return bool
 */
public static function validarEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Conta o tempo decorrido de uma data
 * 
 * @param string $data
 * @return string
 */
public static function contarTempo(string $data): string
{
    $agora = strtotime(date('Y-m-d H:i:s'));
    $tempo = strtotime($data);
    $diferenca = $agora - $tempo;

    $segundos = $diferenca;
    $minutos = round($diferenca / 60);
    $horas = round($diferenca / 3600);
    $dias = round($diferenca / 86400);
    $semanas = round($diferenca / 604800);
    $meses = round($diferenca / 2419200);
    $anos = round($diferenca / 29030400);

    if ($segundos <= 60) {
        return 'agora';
    } elseif ($minutos <= 60) {
        return $minutos == 1 ? 'há 1 minuto' : 'há ' . $minutos . ' minutos';
    } elseif ($horas <= 24) {
        return $horas == 1 ? 'há 1 hora' : 'há ' . $horas . ' horas';
    } elseif ($dias <= 7) {
        return $dias == 1 ? 'há 1 dia' : 'há ' . $dias . ' dias';
    } elseif ($semanas <= 4) {
        return $semanas == 1 ? 'há 1 semana' : 'há ' . $semanas . ' semanas';
    } elseif ($meses <= 7) {
        return $meses == 1 ? 'há 1 mês' : 'há ' . $meses . ' meses';
    } else {
        return $anos == 1 ? 'há 1 ano' : 'há ' . $anos . ' anos';
    }
}

/**
 * Formatar um valor com ponto e virgula
 * 
 * @param float $valor
 * @return string
 */
public static function formatarValor(?float $valor = null): string
{
    return number_format(($valor ? $valor : 0), 2, ',', '.');
}


/**
 * Formata um numero com ponto 
 * 
 * @param int $numero
 * @return string
 */
public static function formatarNumero(int $numero = 0): string
{
    return number_format(($numero ? $numero : 0), 0, '.', '.');
}

public static function saudacao(): string
{
    $hora = date("H");

    // if ($hora >= 0 && $hora <= 5) {
    //     $saudacao = 'Boa madrugada!';
    // } elseif ($hora >= 6 && $hora <= 12) {
    //     $saudacao = 'Bom dia!';
    // } elseif ($hora >= 13 && $hora <= 18) {
    //     $saudacao = 'Boa tarde!';
    // } else {
    //     $saudacao = 'Boa noite!';
    // }

    // switch ($hora) {
    //     case $hora >= 0 && $hora <= 5:
    //         $saudacao = 'Boa madrugada!';
    //         break;
    //     case $hora >= 6 && $hora <= 12: 
    //         $saudacao = 'Bom dia!';
    //         break;
    //     case $hora >= 13 && $hora <= 18: 
    //         $saudacao = 'Boa tarde!';
    //         break;
    //     default: 
    //         $saudacao = 'Boa noite!';
    // }

    $saudacao = match (true) {
        $hora >= 0 and $hora <= 5 => 'Boa madrugada',
        $hora >= 6 and $hora <= 12 => 'Bom dia',
        $hora >= 13 and $hora <= 18 => 'Boa tarde',
        default => 'Boa noite!',
    };

    return $saudacao;
}


/**
 * Resume um texto
 * 
 * @param string $texto texto para resumir
 * @param int $limite quantidade de caracteres
 * @param string $continue opcional - o que deve ser exibido ao final do resumo
 * @return string texto resumido 
 */
public static function resumirTexto(string $texto, int $limite, $continue = '...'): string
{
    $textoLimpo = trim(strip_tags($texto));
    if (mb_strlen($textoLimpo) <= $limite) {
        return $textoLimpo;
    }

    $resumirTexto = mb_substr($textoLimpo, 0, mb_strrpos(mb_substr($textoLimpo, 0, $limite), ''));

    return $resumirTexto . $continue;
}

}