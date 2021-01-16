DROP DATABASE IF EXISTS ABCSTUDIOS ;
CREATE DATABASE ABCSTUDIOS CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ABCSTUDIOS;

CREATE TABLE Curso (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW()
);

CREATE TABLE Administrador (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    email VARCHAR(256) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    CONSTRAINT TB_Administrador_email_U UNIQUE (email)
);

CREATE TABLE Professor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    email VARCHAR(256) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    ultimo_login DATETIME DEFAULT NOW() NOT NULL,
    CONSTRAINT TB_Professor_email_U UNIQUE (email)
);

CREATE TABLE ProfessorContacto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    link TEXT NOT NULL,
    id_professor INT NOT NULL,
    CONSTRAINT TB_ProfessorContacto_Professor_FK FOREIGN KEY (id_professor) REFERENCES Professor(id) ON DELETE CASCADE
);

CREATE TABLE Disciplina (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW(),
    CONSTRAINT TB_Disciplina_nome_U UNIQUE (nome)
);

CREATE TABLE Curso_Disciplina (
    idCurso INT,
    idDisciplina INT,
    CONSTRAINT TB_CursoDisciplina_PKs PRIMARY KEY (idCurso, idDisciplina),
    CONSTRAINT TB_CursoDisciplina_Curso_FK FOREIGN KEY (idCurso) REFERENCES Curso(id) ON DELETE CASCADE,
    CONSTRAINT TB_CursoDisciplina_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id) ON DELETE CASCADE
);

CREATE TABLE Disciplina_Professor (
    idDisciplina INT,
    idProfessor INT,
    CONSTRAINT TB_DisciplinaProfessor_PKs PRIMARY KEY (idDisciplina, idProfessor),
    CONSTRAINT TB_DisciplinaProfessor_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id) ON DELETE CASCADE,
    CONSTRAINT TB_DisciplinaProfessor_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id) ON DELETE CASCADE
);

CREATE TABLE AnoLetivo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL
);

CREATE TABLE Turma (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idCurso INT NOT NULL,
    idAnoLetivo INT NOT NULL,
    CONSTRAINT TB_Turma_Curso_FK FOREIGN KEY (idCurso) REFERENCES Curso(id) ON DELETE CASCADE,
    CONSTRAINT TB_Turma_Anoletivo_FK FOREIGN KEY (idAnoLetivo) REFERENCES AnoLetivo(id) ON DELETE CASCADE
);

CREATE TABLE Aluno (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    email VARCHAR(256) NOT NULL,
    idTurma INT NOT NULL,
    password TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    ultimo_login DATETIME DEFAULT NOW() NOT NULL,
    CONSTRAINT TB_Aluno_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id) ON DELETE CASCADE,
    CONSTRAINT TB_Aluno_email_U UNIQUE (email)
);

CREATE TABLE AlunoContacto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    link TEXT NOT NULL,
    id_aluno INT NOT NULL,
    CONSTRAINT TB_AlunoContacto_Aluno_FK FOREIGN KEY (id_aluno) REFERENCES Aluno(id) ON DELETE CASCADE
);

CREATE TABLE Divisor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idTurma INT NOT NULL,
    idDisciplina INT NOT NULL,
    CONSTRAINT TB_Divisor_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id) ON DELETE CASCADE,
    CONSTRAINT TB_Divisor_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id) ON DELETE CASCADE
);

CREATE TABLE Ficheiro (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    codigo TEXT NOT NULL /* ID COMO O FICHEIRO É GUARDADO */,
    ordem INT NOT NULL,
    e_visivel BOOLEAN DEFAULT TRUE NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idDivisor INT NOT NULL,
    CONSTRAINT TB_Ficheiro_Divisor_FK FOREIGN KEY (idDivisor) REFERENCES Divisor(id) ON DELETE CASCADE
);

CREATE TABLE Submissao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    data_fim DATETIME NOT NULL,
    idDivisor INT NOT NULL,
    CONSTRAINT TB_Submissao_Divisor_FK FOREIGN KEY (idDivisor) REFERENCES Divisor(id) ON DELETE CASCADE
);

CREATE TABLE FicheiroSubmetido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    codigo TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idSubmissao INT NOT NULL,
    CONSTRAINT TB_FicheiroSubmetido_Submissao_FK FOREIGN KEY (idSubmissao) REFERENCES Submissao(id) ON DELETE CASCADE
);

CREATE TABLE Notificacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idTurma INT NOT NULL,
    idDisciplina INT NOT NULL,
    idProfessor INT NOT NULL,
    CONSTRAINT TB_Notificacao_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id) ON DELETE CASCADE,
    CONSTRAINT TB_Notificacao_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id) ON DELETE CASCADE,
    CONSTRAINT TB_Notificacao_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id) ON DELETE CASCADE
);

CREATE TABLE TipoCompromisso (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL
);

CREATE TABLE Compromisso (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    data DATETIME NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idTipo INT NOT NULL,
    idProfessor INT NOT NULL,
    idDisciplina INT NOT NULL,
    idTurma INT NOT NULL,
    CONSTRAINT TB_Compromisso_TipoCompromisso_FK FOREIGN KEY (idTipo) REFERENCES TipoCompromisso(id) ON DELETE CASCADE,
    CONSTRAINT TB_Compromisso_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id) ON DELETE CASCADE,
    CONSTRAINT TB_Compromisso_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id) ON DELETE CASCADE,
    CONSTRAINT TB_Compromisso_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id) ON DELETE CASCADE
);

CREATE TABLE Codigo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(10) NOT NULL, /* ID, Codigo em si */
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    data_fim DATETIME DEFAULT NULL,
    idProfessor INT NOT NULL,
    idDisciplina INT NOT NULL,
    idTurma INT NOT NULL,
    CONSTRAINT TB_Codigo_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id) ON DELETE CASCADE,
    CONSTRAINT TB_Codigo_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id) ON DELETE CASCADE,
    CONSTRAINT TB_Codigo_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id) ON DELETE CASCADE
);

CREATE TABLE Codigo_Aluno (
    idCodigo INT,
    idAluno INT,
    data_presenca DATETIME DEFAULT NOW() NOT NULL,
    CONSTRAINT TB_CodigoAluno_PKs PRIMARY KEY (idCodigo, idAluno),
    CONSTRAINT TB_CodigoAluno_Codigo_FK FOREIGN KEY (idCodigo) REFERENCES Codigo(id) ON DELETE CASCADE,
    CONSTRAINT TB_CodigoAluno_Aluno_FK FOREIGN KEY (idAluno) REFERENCES Aluno(id) ON DELETE CASCADE
);



/* INSERTS */
INSERT INTO Administrador (nome, email, password) VALUES
    ('Miguel Magueijo', 'miguel@abcadmin.pt', MD5('admin')),
    ('Paulo Pinguicha', 'paulo@abcadmin.pt', MD5('admin')),
    ('Tomas Frois', 'tomas@abcadmin.pt', MD5('admin'));

INSERT INTO AnoLetivo VALUES (1, '20/21'), (2, '21/22'), (3, '22/23'), (4, '23/24'), (5, '24/25');

INSERT INTO Curso (id, nome) VALUES 
    (1, 'Engenharia Informática'), (2, 'Engenharia Industrial'), (3, 'Tecnologias da Informação e Multimédia');
INSERT INTO Disciplina (id, nome) VALUES
    (1, 'Programação 1'), (2, 'Probabilidades e Estatística'), (3, 'Álgebra Linear e Geometria Analítica'), 
     (4, 'Inglês Técnico I'), (5, 'Matemática para a Informática I'), (6, 'Sistemas Lógicos');
INSERT INTO Curso_Disciplina VALUES (1,1), (1,2), (1,3), (1,4), (1,5), (1,6);

INSERT INTO Disciplina (id, nome) VALUES
    (7, 'Desenho Técnico'), (8, 'Fundamentos de Termodinâmica'), (9, 'Fundamentos de Matemática'),
     (10, 'Electrotécnia e Instalações Eléctricas'), (11, 'Programação de Computadores');
INSERT INTO Curso_Disciplina VALUES (2,7), (2,8), (2,3), (2,4), (2,9), (2,10), (2,11);

INSERT INTO Disciplina (id, nome) VALUES
    (12, 'Interfaces Pessoa-Máquina I'), (13, 'Lógica'), (14, 'Multimédia I');
INSERT INTO Curso_Disciplina VALUES (3,1), (3,4), (3,2), (3,13), (3,14);

INSERT INTO Turma (id, idCurso, idAnoLetivo) VALUES
    (1,1,1), (2,2,1), (3,3,1), (4,1,2), (5,2,2), (6,3,2);

INSERT INTO Professor (nome, email, password) VALUES
    ('Enzo Viegas', 'enzoviegas@abc.pt', MD5('enzoviegas')), ('Matheus Horta', 'matheushorta@abc.pt', MD5('matheushorta')),
    ('Jacira Pinhal', 'jacirapinhal@abc.pt', MD5('jacirapinhal')), ('Tamara Frota', 'tamarafrota@abc.pt', MD5('tamarafrota')),
    ('Alisa Barreira', 'alisabarreira@abc.pt', MD5('alisabarreira')), ('Teotónio Mourato', 'teotoniomourato@abc.pt', MD5('teotoniomourato')),
    ('Bárbara Moreno', 'barbaramoreno@abc.pt', MD5('barbaramoreno')), ('Samara Boga', 'samaraboga@abc.pt', MD5('samaraboga')),
    ('Fatumata Lacerda', 'fatumatalacerda@abc.pt', MD5('fatumatalacerda')), ('Georgi Figueiro', 'georgifigueiro@abc.pt', MD5('georgifigueiro')), 
    ('Isabel Muniz', 'isabelmuniz@abc.pt', MD5('isabelmuniz')), ('Lígia Varanda', 'ligiavaranda@abc.pt', MD5('ligiavaranda')),
    ('Benício Maranhão', 'beniciomaranhao@abc.pt', MD5('beniciomaranhao')), ('Alba Jesus', 'albajesus@abc.pt', MD5('albajesus')),
    ('Giulia Arouca', 'giuliaarouca@abc.pt', MD5('giuliaarouca')), ('Elizabeth Leitão', 'elizabethleitao@abc.pt', MD5('elizabethleitao'));

INSERT INTO Disciplina_Professor (idDisciplina, idProfessor) VALUES
    (1, 16), (2, 15), (3, 14), (4, 13), (5, 12), (6, 11), (7, 10), (8, 9), (9, 8), (10, 7), (11, 6), (12, 5), (13, 4), (14, 3),
    (2, 2), (4, 1), (6, 1), (8, 2), (10, 3), (12, 4);

INSERT INTO Aluno (nome, email, password, idTurma) VALUES
    ('Angelo Maciel', 'angelomaciel@abccampus.pt', MD5('aluno'), 1), ('Anselmo Valadão', 'anselmovaladao@abccampus.pt', MD5('aluno'), 1),
    ('Augusto Rego', 'augustorego@abccampus.pt', MD5('aluno'), 1), ('Nicollas Mota', 'nicollasmota@abccampus.pt', MD5('aluno'), 1),
    ('Estrela Tristão', 'estrelatristao@abccampus.pt', MD5('aluno'), 1);

INSERT INTO Aluno (nome, email, password, idTurma) VALUES
    ('Fábia Regueira', 'fabiaregueira@abccampus.pt', MD5('aluno'), 2), ('Sofia Lacerda', 'sofialacerda@abccampus.pt', MD5('aluno'), 2),
    ('Agostinho Rabelo', 'agostinhorabelo@abccampus.pt', MD5('aluno'), 2), ('Alexandro Proença', 'alexandroproenca@abccampus.pt', MD5('aluno'), 2),
    ('Lúcio Caeiro', 'luciocaeiro@abccampus.pt', MD5('aluno'), 2);

INSERT INTO Aluno (nome, email, password, idTurma) VALUES
    ('Anastasia Mantas', 'anastasiamantas@abccampus.pt', MD5('aluno'), 3), ('Joelma Flávio', 'joelmaflavio@abccampus.pt', MD5('aluno'), 3),
    ('Angela Landim', 'angelalandim@abccampus.pt', MD5('aluno'), 3), ('Joice Igrejas', 'joiceigrejas@abccampus.pt', MD5('aluno'), 3),
    ('Kévim Garrido', 'kevimgarrido@abccampus.pt', MD5('aluno'), 3);