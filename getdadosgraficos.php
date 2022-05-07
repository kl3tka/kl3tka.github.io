<?php

// Estrutura basica do grafico
$grafico = array(
    'dados' => array(
        'cols' => array(
            array('type' => 'string', 'label' => 'Gênero'),
            array('type' => 'number', 'label' => 'Quantidade')
        ),  
        'rows' => array()
    ),
    'config' => array(
        'title' => 'Quantidade de livro por gênero',
        'width' => 500,
        'height' => 400
    )
);

// Consultar dados no BD
$pdo = new PDO("mysql:host=localhost;dbname=app_gerenciamento_concessionaria","root","");
//inner join serve para juntar 2 ou mais entidades com o mesmo codigo relacional entre livro e genero
$sql ='SELECT tb_modelos_novos.preco, COUNT(*) as preco FROM tb_modelos_seminovos inner join preco on tbmodelos_novos.preco = tb_modelos_seminovos.preco GROUP BY tbmodelos_novos.preco';
//$sql = 'SELECT genero, COUNT(*) as quantidade FROM tb_livro  GROUP BY cod_genero';
$stmt = $pdo->query($sql);
while ($obj = $stmt->fetchObject()) {//pegar todos os registros que retornaram da consulta
    //monta as informações para gerar o grafico
    $grafico['dados']['rows'][] = array('c' => array(
        array('v' => $obj->preco),
        array('v' => (int)$obj->preco)
    ));
}

// Enviar dados na forma de JSON
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($grafico);
exit(0);