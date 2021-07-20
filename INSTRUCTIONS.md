## Para o teste foi utilizado Xamp
- na pasta raiz do servidor web criar uma nova pasta com o nome luciano-teste
- os arquivos do projeto devem ser baixados nesta pasta.
- criar um banco de dados mysql com o nome "luciano_teste"

## Rodar o php artisan migrate para gerar as tabelas
## EndPoints
{
	"info": {
		"_postman_id": "0f846fca-46f4-428b-9069-e24a1738a3d8",
		"name": "DESAFIO BACK-END Luciano Mineli",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
	},
	"item": [
		{
			"name": "http://localhost/luciano-teste/public/api/usuarios",
			"protocolProfileBehavior": {
				"disableBodyPruning": true
			},
			"request": {
				"method": "GET",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/usuarios",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"usuarios"
					]
				},
				"description": "listar usuários"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/usuarios",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"usuarios"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/usuarios/1",
			"protocolProfileBehavior": {
				"disableBodyPruning": true
			},
			"request": {
				"method": "GET",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/usuarios/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"usuarios",
						"1"
					]
				},
				"description": "listar usuário específico"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/usuarios/1",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"usuarios",
								"1"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/usuarios/1",
			"request": {
				"method": "DELETE",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/usuarios/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"usuarios",
						"1"
					]
				},
				"description": "excluir um usuário específico"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "DELETE",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/usuarios/1",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"usuarios",
								"1"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/usuarios?name=&email=&birthday=",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/usuarios?name=&email=&birthday=",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"usuarios"
					],
					"query": [
						{
							"key": "name",
							"value": ""
						},
						{
							"key": "email",
							"value": ""
						},
						{
							"key": "birthday",
							"value": ""
						}
					]
				},
				"description": "Inserir um novo usuário"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/usuarios?name=&email=&birthday=",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"usuarios"
							],
							"query": [
								{
									"key": "name",
									"value": ""
								},
								{
									"key": "email",
									"value": ""
								},
								{
									"key": "birthday",
									"value": ""
								}
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/usuarios/1?name=&email=&birthday=",
			"request": {
				"method": "PUT",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/usuarios/1?name=&email=&birthday=",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"usuarios",
						"1"
					],
					"query": [
						{
							"key": "name",
							"value": ""
						},
						{
							"key": "email",
							"value": ""
						},
						{
							"key": "birthday",
							"value": ""
						}
					]
				},
				"description": "atualiza um usuário"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "PUT",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/usuarios/1?name=&email=&birthday=",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"usuarios",
								"1"
							],
							"query": [
								{
									"key": "name",
									"value": ""
								},
								{
									"key": "email",
									"value": ""
								},
								{
									"key": "birthday",
									"value": ""
								}
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/movimentacoes",
			"protocolProfileBehavior": {
				"disableBodyPruning": true
			},
			"request": {
				"method": "GET",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/movimentacoes",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"movimentacoes"
					]
				},
				"description": "listagem de movimentações"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/movimentacoes",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"movimentacoes"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/movimentacoes/1",
			"protocolProfileBehavior": {
				"disableBodyPruning": true
			},
			"request": {
				"method": "GET",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/movimentacoes/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"movimentacoes",
						"1"
					]
				},
				"description": "lista uma movimentação específica"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/movimentacoes/1",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"movimentacoes",
								"1"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/movimentacoes?page=1",
			"protocolProfileBehavior": {
				"disableBodyPruning": true
			},
			"request": {
				"method": "GET",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/movimentacoes?page=1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"movimentacoes"
					],
					"query": [
						{
							"key": "page",
							"value": "1"
						}
					]
				},
				"description": "lista movimentações por página"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/movimentacoes?page=1",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"movimentacoes"
							],
							"query": [
								{
									"key": "page",
									"value": "1"
								}
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/movimentacoes?tp_movimentacao=&id_usuario=&vlr_movimentacao=",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/movimentacoes?tp_movimentacao=&id_usuario=&vlr_movimentacao=",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"movimentacoes"
					],
					"query": [
						{
							"key": "tp_movimentacao",
							"value": ""
						},
						{
							"key": "id_usuario",
							"value": ""
						},
						{
							"key": "vlr_movimentacao",
							"value": ""
						}
					]
				},
				"description": "insere uma movimentação"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/movimentacoes?tp_movimentacao=&id_usuario=&vlr_movimentacao=",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"movimentacoes"
							],
							"query": [
								{
									"key": "tp_movimentacao",
									"value": ""
								},
								{
									"key": "id_usuario",
									"value": ""
								},
								{
									"key": "vlr_movimentacao",
									"value": ""
								}
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/movimentacoes/1",
			"request": {
				"method": "DELETE",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/movimentacoes/1",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"movimentacoes",
						"1"
					]
				},
				"description": "exclui uma movimentação"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "DELETE",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/movimentacoes/1",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"movimentacoes",
								"1"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		},
		{
			"name": "http://localhost/luciano-teste/public/api/movimentacoes/1?",
			"request": {
				"method": "PUT",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": ""
				},
				"url": {
					"raw": "http://localhost/luciano-teste/public/api/movimentacoes/1?",
					"protocol": "http",
					"host": [
						"localhost"
					],
					"path": [
						"luciano-teste",
						"public",
						"api",
						"movimentacoes",
						"1"
					]
				},
				"description": "atualiza uma movimentação"
			},
			"response": [
				{
					"name": "Default",
					"originalRequest": {
						"method": "PUT",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": ""
						},
						"url": {
							"raw": "http://localhost/luciano-teste/public/api/movimentacoes/1?",
							"protocol": "http",
							"host": [
								"localhost"
							],
							"path": [
								"luciano-teste",
								"public",
								"api",
								"movimentacoes",
								"1"
							]
						}
					},
					"code": 200,
					"_postman_previewlanguage": null,
					"header": null,
					"cookie": [],
					"body": ""
				}
			]
		}
	]
}
