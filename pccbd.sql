CREATE DATABASE pccbd2;
USE pccbd2;

CREATE TABLE `admins` (
  `nome` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cpf` char(11) COLLATE utf8_bin NOT NULL,
  `senha` varchar(15) COLLATE utf8_bin NOT NULL,
  `chef` varchar(1) COLLATE utf8_bin NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `admins` (`nome`, `cpf`, `senha`, `chef`) VALUES
('Vanessa Ayla Castro', '02807985637', '123456789', '0'),
('João José da Silva', '74649196027', '123415263', '1');

CREATE TABLE `direcao` (
  `nome` varchar(100) COLLATE utf8_bin NOT NULL,
  `cpf` char(11) COLLATE utf8_bin NOT NULL,
  `senha` varchar(15) COLLATE utf8_bin NOT NULL,
  `funcao` varchar(1) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `direcao` (`nome`, `cpf`, `senha`, `funcao`) VALUES
('Cauã José da Rocha', '70023531606', '123456789', '1'),
('Iago Severino Pedro Ferreira', '77451003302', '123456789', '0');

CREATE TABLE `professores` (
  `nome` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cpf` char(11) COLLATE utf8_bin NOT NULL,
  `senha` varchar(15) COLLATE utf8_bin NOT NULL,
  `alocacao` char(1) COLLATE utf8_bin NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `professores` (`nome`, `cpf`, `senha`, `alocacao`) VALUES
('JosÃ© da Silva ', '54659810089', '123456789', '0'),
('Bryan Erick Figueiredo', '67923679070', '123456789', '1'),
('Lavínia Antonella Corte Real', '93490119649', '123456789', '1'),
('JÃ©ssica NatÃ¡lia Amanda da Rosa', '99832539099', '123456789', '1');

CREATE TABLE `disciplinas` (
  `codigo_disciplina` smallint(2) NOT NULL,
  `nome_disciplina` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `disciplinas` (`codigo_disciplina`, `nome_disciplina`) VALUES
(1, 'Matemática'),
(2, 'Português'),
(3, 'Ciências'),
(4, 'História');

CREATE TABLE `alunos` (
  `nome` varchar(100) COLLATE utf8_bin NOT NULL,
  `cpf` char(11) COLLATE utf8_bin NOT NULL,
  `matricula` char(8) COLLATE utf8_bin NOT NULL,
  `sexo` char(1) COLLATE utf8_bin NOT NULL,
  `responsavel1` varchar(100) COLLATE utf8_bin NOT NULL,
  `responsavel2` varchar(100) COLLATE utf8_bin NOT NULL,
  `data_nascimento` date NOT NULL,
  `senha` varchar(15) COLLATE utf8_bin NOT NULL,
  `turma` char(3) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `coment` (
  `codigo` varchar(6) COLLATE utf8_bin NOT NULL,
  `texto` varchar(1000) COLLATE utf8_bin NOT NULL,
  `data_adc` date NOT NULL,
  `cpf_aluno` char(11) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `faltas` (
  `aluno` char(11) COLLATE utf8_bin NOT NULL,
  `data` date NOT NULL,
  `justificada` varchar(1) COLLATE utf8_bin NOT NULL,
  `descricao` varchar(150) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `notas` (
  `aluno` char(11) COLLATE utf8_bin NOT NULL,
  `nota_1_p1` decimal(3,1) DEFAULT NULL,
  `nota_1_p2` decimal(3,1) DEFAULT NULL,
  `nota_1_p3` decimal(3,1) DEFAULT NULL,
  `nota_1_p4` decimal(3,1) DEFAULT NULL,
  `nota_2_p1` decimal(3,1) DEFAULT NULL,
  `nota_2_p2` decimal(3,1) DEFAULT NULL,
  `nota_2_p3` decimal(3,1) DEFAULT NULL,
  `nota_2_p4` decimal(3,1) DEFAULT NULL,
  `nota_3_p1` decimal(3,1) DEFAULT NULL,
  `nota_3_p2` decimal(3,1) DEFAULT NULL,
  `nota_3_p3` decimal(3,1) DEFAULT NULL,
  `nota_3_p4` decimal(3,1) DEFAULT NULL,
  `nota_4_p1` decimal(3,1) DEFAULT NULL,
  `nota_4_p2` decimal(3,1) DEFAULT NULL,
  `nota_4_p3` decimal(3,1) DEFAULT NULL,
  `nota_4_p4` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `turmas` (
  `codigo` char(3) COLLATE utf8_bin NOT NULL,
  `cpf_professor` char(11) COLLATE utf8_bin NOT NULL,
  `turno` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `admins`
  ADD PRIMARY KEY (`cpf`);


ALTER TABLE `alunos`
  ADD PRIMARY KEY (`cpf`),
  ADD KEY `alunos_ibfk_1` (`turma`);


ALTER TABLE `coment`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cpf_aluno` (`cpf_aluno`);


ALTER TABLE `direcao`
  ADD PRIMARY KEY (`cpf`);

ALTER TABLE `disciplinas`
  ADD PRIMARY KEY (`codigo_disciplina`,`nome_disciplina`);


ALTER TABLE `faltas`
  ADD PRIMARY KEY (`aluno`,`data`);


ALTER TABLE `notas`
  ADD KEY `aluno` (`aluno`);


ALTER TABLE `professores`
  ADD PRIMARY KEY (`cpf`);


ALTER TABLE `turmas`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cpf_professor` (`cpf_professor`) USING BTREE;


ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`turma`) REFERENCES `turmas` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `coment`
  ADD CONSTRAINT `coment_ibfk_1` FOREIGN KEY (`cpf_aluno`) REFERENCES `alunos` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `faltas`
  ADD CONSTRAINT `faltas_ibfk_1` FOREIGN KEY (`aluno`) REFERENCES `alunos` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`aluno`) REFERENCES `alunos` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `turmas`
  ADD CONSTRAINT `turmas_ibfk_1` FOREIGN KEY (`cpf_professor`) REFERENCES `professores` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

INSERT INTO `turmas` (`codigo`, `cpf_professor`, `turno`) VALUES
('1AV', '99832539099', 'Vespertino'),
('2AM', '93490119649', 'Matutino'),
('4AV', '67923679070', 'Vespertino');

INSERT INTO `alunos` (`nome`, `cpf`, `matricula`, `sexo`, `responsavel1`, `responsavel2`, `data_nascimento`, `senha`, `turma`) VALUES
('Isabela Stefany Raquel Monteiro', '30426640233', '20193676', 'F', 'Fátima Melissa', 'Oliver Severino Monteiro', '2012-01-07', '123456789', '1AV'),
('Analu Brenda Galvão', '32315389631', '20197346', 'F', 'Aurora Mariah', '', '2012-09-01', '123456789', '1AV'),
('Carlos Eduardo Freitas', '32520306831', '20196394', 'M', 'Giovana Louise', 'Thales Nathan Freitas', '2011-12-30', '123456789', '2AM'),
('Vicente Augusto Fernandes', '37159562836', '20191012', 'M', 'Raimunda Bianca', '', '2009-08-17', '123456789', '4AV'),
('Tiago Emanuel Castro', '39137854267', '2019889', 'M', 'Martin Levi Castro', '', '2009-08-10', '123456789', '4AV'),
('Camila Nicole Cardoso', '48524100389', '2019825', 'F', 'Isis Nair', 'Leandro Carlos Cauê Cardoso', '2009-08-01', '123456789', '4AV'),
('Patrícia Kamilly Giovana Souza', '56719167472', '2019226', 'F', 'Bárbara Olivia Isis', 'Rodrigo Caleb Giovanni Souza', '2011-05-12', '123456789', '2AM'),
('Luiza Benedita Ramos', '65130037685', '20193950', 'F', 'Carolina Lorena', 'Márcio Raimundo Ramos', '2010-01-15', '123456789', '4AV'),
('Nina Elza Cecília Santos', '68284348110', '20191526', 'F', 'Isabelle Tânia', 'Tomás Theo Santos', '2012-02-01', '123456789', '1AV'),
('Márcio Rodrigo Aragão', '73240536706', '20199278', 'M', 'Gabrielly Beatriz Joana', 'Giovanni Mateus Paulo Aragão', '2011-03-25', '123456789', '2AM'),
('Pedro Vinicius Yago Fernandes', '77354341894', '20198517', 'M', 'Alana Malu Bárbara', 'Bruno Levi Osvaldo Fernandes', '2012-06-03', '123456789', '1AV'),
('Lúcia Rita Bruna Mendes', '80952948290', '20193541', 'F', 'Bárbara Simone Elza', 'Fernando Paulo Mendes', '2011-05-17', '123456789', '2AM'),
('Manuela Emilly Pires', '94075267121', '20191259', 'F', 'Renata Isabel Bianca', 'Davi Eduardo Juan Pires', '2009-04-13', '123456789', '4AV'),
('Mariane Rafaela Moura', '99538326920', '2019932', 'F', 'Betina Luna', 'Fernando Marcelo Eduardo Moura', '2011-04-09', '123456789', '2AM');

INSERT INTO `coment` (`codigo`, `texto`, `data_adc`, `cpf_aluno`) VALUES
('389550', 'A aluna não está se comportando corretamente para o ambiente da sala de aula.', '2019-10-21', '65130037685'),
('420858', 'A aluna está bagunçando muito na sala de aula. Conversando com os colegas e não fazendo as atividades.', '2019-10-21', '94075267121'),
('611817', 'O aluno está conversando bastante durante a aula.', '2019-10-21', '77354341894'),
('809463', 'O aluno sai frequentemente da sala sem pedir permissão.', '2019-10-21', '77354341894'),
('968195', 'A aluna passou mal no dia 18/10/19, então foi encaminhada para um posto de saúde mais próximo e depois levada para a casa.', '2019-10-21', '99538326920');

INSERT INTO `faltas` (`aluno`, `data`, `justificada`, `descricao`) VALUES
('32315389631', '2019-09-08', '0', 'A aluna alegou que foi ao médico, porém não apresentou atestado. A falta não foi justificada (Até que se apresente algum atestado).'),
('32520306831', '2019-04-20', '0', ''),
('37159562836', '2019-04-04', '0', ''),
('37159562836', '2019-07-12', '0', ''),
('39137854267', '2019-09-30', '0', ''),
('39137854267', '2019-10-08', '0', ''),
('39137854267', '2019-10-15', '0', ''),
('39137854267', '2019-10-21', '0', ''),
('48524100389', '2019-09-17', '0', ''),
('56719167472', '2019-07-06', '0', ''),
('56719167472', '2019-07-07', '0', ''),
('65130037685', '2019-04-27', '1', 'A aluna esteve no médico.'),
('68284348110', '2019-06-04', '0', ''),
('68284348110', '2019-08-17', '0', ''),
('73240536706', '2019-09-24', '0', ''),
('99538326920', '2019-10-08', '1', 'A aluna foi ao médico');

INSERT INTO `notas` (`aluno`, `nota_1_p1`, `nota_1_p2`, `nota_1_p3`, `nota_1_p4`, `nota_2_p1`, `nota_2_p2`, `nota_2_p3`, `nota_2_p4`, `nota_3_p1`, `nota_3_p2`, `nota_3_p3`, `nota_3_p4`, `nota_4_p1`, `nota_4_p2`, `nota_4_p3`, `nota_4_p4`) VALUES
('77354341894', '5.6', '7.8', '7.8', '5.6', '7.5', '9.5', '5.6', '4.5', '4.6', '4.6', '9.5', '7.8', '8.9', '5.6', '7.8', '6.1'),
('32315389631', '8.8', '4.5', '7.8', '6.5', '3.5', '6.5', '8.9', '5.9', '6.4', '7.8', '4.3', '8.9', '8.6', '8.4', '1.5', '9.9'),
('30426640233', '6.6', '7.8', '6.8', '5.6', '5.9', '6.8', '8.9', '4.6', '4.9', '8.9', '7.6', '6.0', '8.8', '5.3', '5.9', '8.4'),
('68284348110', '6.5', '9.8', '7.8', '8.8', '8.4', '5.6', '8.5', '5.6', '7.6', '4.6', '4.6', '4.6', '9.5', '7.8', '7.8', '7.8'),
('56719167472', '5.4', '9.0', '7.8', '4.0', '6.5', '7.8', '7.2', '5.6', '8.0', '5.6', '8.9', '8.6', '7.0', '4.3', '9.8', '7.1'),
('32520306831', '8.5', '9.8', '7.5', '6.5', '6.5', '7.5', '4.6', '6.8', '4.6', '2.5', '8.0', '8.5', '9.8', '5.9', '10.0', '7.2'),
('99538326920', '10.0', '9.8', '8.4', '10.0', '8.9', '7.6', '8.1', '7.6', '8.0', '9.7', '9.2', '8.3', '9.0', '9.7', '9.0', '9.1'),
('73240536706', '7.0', '6.0', '8.5', '6.5', '8.0', '6.4', '4.5', '8.5', '9.0', '7.8', '8.0', '8.7', '6.5', '9.3', '6.3', '6.0'),
('80952948290', '6.5', '6.5', '7.8', '8.8', '4.5', '7.5', '5.6', '7.6', '8.8', '5.3', '7.4', '7.9', '9.6', '4.6', '7.9', '9.8'),
('39137854267', '8.6', '8.6', '7.0', '8.6', '7.6', '9.6', '8.6', '7.6', '8.1', '7.2', '9.0', '6.5', '4.6', '8.6', '7.2', '4.6'),
('48524100389', '6.5', '8.0', '6.5', '7.5', '6.4', '7.0', '8.4', '8.6', '8.9', '6.0', '7.2', '4.3', '7.8', '9.0', '4.6', '8.6'),
('65130037685', '6.5', '4.5', '8.8', '7.8', '8.7', '7.6', '7.6', '5.6', '4.6', '8.5', '8.4', '7.8', '9.8', '5.9', '5.8', '9.6'),
('94075267121', '8.6', '8.6', '7.3', '8.3', '7.4', '7.3', '8.6', '7.6', '6.3', '9.3', '4.5', '9.2', '9.3', '4.9', '7.3', '5.9'),
('37159562836', '7.6', '6.8', '9.8', '7.8', '8.1', '6.4', '5.6', '5.6', '4.6', '8.9', '7.8', '9.5', '8.7', '7.8', '7.6', '10.0');