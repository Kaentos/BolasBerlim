# Regras de alteração de SQL

##### ATENÇÃO:
**Todo o texto dentro de `<>` é para ser trocado por outro texto sem `<>`, ex: `<nome>` = Aluno.<br>
O não entendimento das regras deve ser comunicado ao criador da base de dados para ajudar [Kaentos](https://github.com/Kaentos)**

#### Todo código SQL deve ser em maíusculas
Exemplo:
```sql
CREATE TABLE, NOW(), DATETIME
```

### Regras de declarações:
##### Campo:
* Deve seguir a seguinte ordem: `<nome campo> <tipo> DEFAULT <DEFAULT value> NOT NULL PRIMARY KEY AUTO_INCREMENT`
* Exemplo: `nome TEXT NOT NULL`, `id INT PRIMARY KEY AUTO_INCREMENT`, `data_criacao DATETIME DEFAULT NOW() NOT NULL`

##### PRIMARY KEY:
* Deve possuir AUTO_INCREMENT sempre que possivel
* Quando é mais do que uma, deve ser feita com CONSTRAINT
    
##### FOREIGN KEY:
* Deve ser sempre feita com CONSTRAINT

##### UNIQUE:
* Deve ser sempre feita com CONSTRAINT


### Regras de nomes:

##### Constraints:
Deve seguir o formato:
* PRIMARY KEY `TB_<nome tabela>_PK` ou `TB_<nome tabela>_PKs` (caso seja mais do que uma)
* FOREIGN KEY `TB_<nome tabela>_<nome tabela referenciada>_FK`
* UNIQUE `TB_<nome tabela>_<campo>_U`
* `<nome tabela>` e `<nome tabela referenciada>` deve ser feita sem espaços e _ e deve possuir sempre maíuscula na primeira letra da palavra, ex: TipoAluno
* `<campo>` deve ser feito sem espaços e _ e com a primeira letra minúscula, ex: dataCriacao
        
##### Tabelas:
* Primeira letra maíuscula,
* 2 ou 1+N palavra igual (ex: BomDia, UmExemploParaTabela)

##### Tabelas de relacionamento:
* Deve seguir a seguinte formatação: `<nome tabela 1>_<nome tabela 2>`, ex: TipoAluno_Aluno
* O primeiro campo desta tabela deverá ser a FOREIGN KEY da tabela na primeira posição (`<nome tabela 1>`)
* O nome de cada tabela não deve ser separado por espaço ou _ e deve possuir sempre a primeira posição de cada palavra maíuscula, ex: Aluno_AlunoContacto

##### Campos:
* Tudo minúscula,
* 2 ou 1+N palavra igual e separada por _ (ex: nome_completo, um_exemplo_para_campo)

##### Campo estrangeiro (FOREIGN KEY):
* Não deve conter espaços e a primeira palavra deve ser minúscula e as seguintes devem possuir letra maíuscula na primeira posição, ex: idTipo