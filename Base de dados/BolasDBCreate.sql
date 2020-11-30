DROP DATABASE ABCSTUDIOS;
CREATE DATABASE ABCSTUDIOS;
USE ABCSTUDIOS;

CREATE TABLE Aluno (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    email VARCHAR(256) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    ultimo_login DATETIME DEFAULT NOW() NOT NULL,
    CONSTRAINT TB_Aluno_email_U UNIQUE (email)
);

CREATE TABLE AlunoContacto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    link TEXT NOT NULL,
    id_aluno INT NOT NULL,
    CONSTRAINT TB_AlunoContacto_Aluno_FK FOREIGN KEY (id_aluno) REFERENCES Aluno(id)
);

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
    CONSTRAINT TB_ProfessorContacto_Professor_FK FOREIGN KEY (id_professor) REFERENCES Professor(id)
);

CREATE TABLE Disciplina (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW()
);

CREATE TABLE Curso_Disciplina (
    idCurso INT,
    idDisciplina INT,
    CONSTRAINT TB_CursoDisciplina_PKs PRIMARY KEY (idCurso, idDisciplina),
    CONSTRAINT TB_CursoDisciplina_Curso_FK FOREIGN KEY (idCurso) REFERENCES Curso(id),
    CONSTRAINT TB_CursoDisciplina_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id)
);

CREATE TABLE Disciplina_Professor (
    idDisciplina INT,
    idProfessor INT,
    CONSTRAINT TB_DisciplinaProfessor_PKs PRIMARY KEY (idDisciplina, idProfessor),
    CONSTRAINT TB_DisciplinaProfessor_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id),
    CONSTRAINT TB_DisciplinaProfessor_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id)
);

CREATE TABLE AnoLetivo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL
);

CREATE TABLE Turma (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    id_anoLetivo INT NOT NULL,
    CONSTRAINT TB_Turma_Anoletivo_FK FOREIGN KEY (id_anoLetivo) REFERENCES AnoLetivo(id)
);

CREATE TABLE Divisor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idTurma INT NOT NULL,
    idDisciplina INT NOT NULL,
    CONSTRAINT TB_Divisor_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id),
    CONSTRAINT TB_Divisor_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id)
);

CREATE TABLE Ficheiro (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    codigo TEXT NOT NULL /* ID COMO O FICHEIRO É GUARDADO */,
    ordem INT NOT NULL,
    e_visivel BOOLEAN DEFAULT TRUE NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idDivisor INT NOT NULL,
    CONSTRAINT TB_Ficheiro_Divisor_FK FOREIGN KEY (idDivisor) REFERENCES Divisor(id)
);

CREATE TABLE Submissao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    data_fim DATETIME NOT NULL,
    idDivisor INT NOT NULL,
    CONSTRAINT TB_Submissao_Divisor_FK FOREIGN KEY (idDivisor) REFERENCES Divisor(id)
);

CREATE TABLE FicheiroSubmetido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome TEXT NOT NULL,
    codigo TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idSubmissao INT NOT NULL,
    CONSTRAINT TB_FicheiroSubmetido_Submissao_FK FOREIGN KEY (idSubmissao) REFERENCES Submissao(id)
);

CREATE TABLE Notificacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    idTurma INT NOT NULL,
    idDisciplina INT NOT NULL,
    idProfessor INT NOT NULL,
    CONSTRAINT TB_Notificacao_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id),
    CONSTRAINT TB_Notificacao_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id),
    CONSTRAINT TB_Notificacao_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id)
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
    CONSTRAINT TB_Compromisso_TipoCompromisso_FK FOREIGN KEY (idTipo) REFERENCES TipoCompromisso(id),
    CONSTRAINT TB_Compromisso_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id),
    CONSTRAINT TB_Compromisso_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id),
    CONSTRAINT TB_Compromisso_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id)
);

CREATE TABLE Codigo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(10) NOT NULL, /* ID, Codigo em si */
    data_criacao DATETIME DEFAULT NOW() NOT NULL,
    data_fim DATETIME DEFAULT NULL,
    idProfessor INT NOT NULL,
    idDisciplina INT NOT NULL,
    idTurma INT NOT NULL,
    CONSTRAINT TB_Codigo_Professor_FK FOREIGN KEY (idProfessor) REFERENCES Professor(id),
    CONSTRAINT TB_Codigo_Disciplina_FK FOREIGN KEY (idDisciplina) REFERENCES Disciplina(id),
    CONSTRAINT TB_Codigo_Turma_FK FOREIGN KEY (idTurma) REFERENCES Turma(id)
);

CREATE TABLE Codigo_Aluno (
    idCodigo INT NOT NULL,
    idAluno INT NOT NULL,
    data_presenca DATETIME DEFAULT NOW() NOT NULL,
    CONSTRAINT TB_CodigoAluno_PKs PRIMARY KEY (idCodigo, idAluno),
    CONSTRAINT TB_CodigoAluno_Codigo_FK FOREIGN KEY (idCodigo) REFERENCES Codigo(id),
    CONSTRAINT TB_CodigoAluno_Aluno_FK FOREIGN KEY (idAluno) REFERENCES Aluno(id)
);

CREATE TRIGGER CodigoCheckLimit BEFORE INSERT ON Codigo FOR EACH ROW
BEGIN
    IF NEW.data_fim IS NULL THEN
        SET NEW.data_fim = (SELECT DATE_ADD(NEW.data_criacao, INTERVAL 5 MINUTE));
    END IF;
END;