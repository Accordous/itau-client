<?php

namespace Itau\Tests\Feature;

use Itau\Tests\TestCase;
use Itau\Facades\Itau;
use Illuminate\Support\Facades\Cache;

class RegistrarBoletoCobrancaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear the cache before each test
        Cache::flush();
    }

    /** @test */
    public function it_can_register_boleto_cobranca()
    {
        // Skip this test if environment variables are not set
        if (empty(config('itau.client_id')) || 
            empty(config('itau.client_secret'))) {
            $this->markTestSkipped('API credentials not configured.');
        }

        // Prepare test data
        $data = [
            "codigo_canal_operacao" => "BKL",
            "etapa_processo_boleto" => "validacao",
            "beneficiario" => [
                "tipo_pessoa" => [
                    "numero_cadastro_pessoa_fisica" => "12345678901",
                    "codigo_tipo_pessoa" => "J",
                    "numero_cadastro_nacional_pessoa_juridica" => "12345678901234"
                ],
                "nome_cobranca" => "Antonio Coutinho SA",
                "endereco" => [
                    "nome_cidade" => "Sao Paulo",
                    "nome_logradouro" => "rua dona ana neri, 368",
                    "sigla_UF" => "SP",
                    "numero_CEP" => "12345678",
                    "nome_bairro" => "Mooca"
                ],
                "id_beneficiario" => "150000052061"
            ],
            "dado_boleto" => [
                "data_emissao" => "2000-01-01",
                "codigo_carteira" => "112",
                "texto_uso_beneficiario" => "726351275ABC",
                "recebimento_divergente" => [
                    "valor_maximo" => "999999999999999.00",
                    "valor_minimo" => "999999999999999.00",
                    "codigo_tipo_autorizacao" => 1,
                    "percentual_maximo" => "9999999.00000",
                    "percentual_minimo" => "9999999.00000"
                ],
                "pagamento_parcial" => false,
                "quantidade_parcelas" => 2,
                "pagador" => [
                    "texto_endereco_email" => "itau@itau-unibanco.com.br",
                    "endereco" => [
                        "nome_cidade" => "Sao Paulo",
                        "nome_logradouro" => "rua dona ana neri, 368",
                        "sigla_UF" => "SP",
                        "numero_CEP" => "12345678",
                        "nome_bairro" => "Mooca"
                    ],
                    "id_pagador" => "298AFB64-F607-454E-8FC9-4765B70B7828",
                    "pessoa" => [
                        "nome_fantasia" => "Empresa A",
                        "nome_pessoa" => "Antônio Coutinho",
                        "tipo_pessoa" => [
                            "numero_cadastro_pessoa_fisica" => "12345678901",
                            "codigo_tipo_pessoa" => "J",
                            "numero_cadastro_nacional_pessoa_juridica" => "12345678901234"
                        ]
                    ]
                ],
                "quantidade_maximo_parcial" => 2,
                "descricao_especie" => "BDP Boleto proposta",
                "tipo_boleto" => "proposta",
                "dados_individuais_boleto" => [],
                "desconto_expresso" => true,
                "codigo_aceite" => "S",
                "codigo_tipo_vencimento" => 1,
                "sacador_avalista" => [
                    "exclusao_sacador_avalista" => true,
                    "pessoa" => [
                        "nome_fantasia" => "Empresa A",
                        "nome_pessoa" => "Antônio Coutinho",
                        "tipo_pessoa" => [
                            "numero_cadastro_pessoa_fisica" => "12345678901",
                            "codigo_tipo_pessoa" => "J",
                            "numero_cadastro_nacional_pessoa_juridica" => "12345678901234"
                        ]
                    ],
                    "endereco" => [
                        "nome_cidade" => "Sao Paulo",
                        "nome_logradouro" => "rua dona ana neri, 368",
                        "sigla_UF" => "SP",
                        "numero_CEP" => "12345678",
                        "nome_bairro" => "Mooca"
                    ]
                ],
                "valor_abatimento" => "100.00",
                "protesto" => [
                    "quantidade_dias_protesto" => 1,
                    "protesto_falimentar" => true,
                    "codigo_tipo_protesto" => 1
                ],
                "descricao_instrumento_cobranca" => "boleto",
                "juros" => [
                    "data_juros" => "2024-09-21",
                    "codigo_tipo_juros" => "90",
                    "valor_juros" => "999999999999999.00",
                    "quantidade_dias_juros" => 1,
                    "percentual_juros" => "000000100000"
                ],
                "negativacao" => [
                    "codigo_tipo_negativacao" => 1,
                    "quantidade_dias_negativacao" => 1
                ],
                "forma_envio" => "impressão",
                "multa" => [
                    "codigo_tipo_multa" => "01",
                    "quantidade_dias_multa" => 1,
                    "valor_multa" => "999999999999999.00",
                    "percentual_multa" => "9999999.00000"
                ],
                "desconto" => [
                    "codigo_tipo_desconto" => "01",
                    "mensagem" => "Aguardando aprovação",
                    "descontos" => [],
                    "codigo" => "200"
                ],
                "historico" => [],
                "baixa" => [
                    "codigo" => "200",
                    "indicador_dia_util_baixa" => "0",
                    "campos" => [],
                    "data_hora_inclusao_alteracao_baixa" => "2016-02-28T16:41:41.090Z",
                    "mensagem" => "Aguardando aprovação",
                    "codigo_usuario_inclusao_alteracao" => "000000001",
                    "data_inclusao_alteracao_baixa" => "2016-02-28",
                    "codigo_motivo_boleto_cobranca_baixado" => "33"
                ],
                "pagamentos_cobranca" => [],
                "mensagens_cobranca" => [],
                "instrucao_cobranca" => [],
                "codigo_especie" => "01"
            ],
            "id_boleto" => "b1ff5cc0-8a9c-497e-b983-738904c23386",
            "acoes_permitidas" => [
                "comandar_instrucao_alterar_dados_cobranca" => false,
                "emitir_segunda_via" => false
            ]
        ];

        $response = Itau::registrarBoletoCobranca($data);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('dado_boleto', $response);
    }
} 