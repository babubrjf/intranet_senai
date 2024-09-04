-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 04/09/2024 às 10:51
-- Versão do servidor: 8.0.35-cll-lve
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `intranet_jfn`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ambiente`
--

CREATE TABLE `ambiente` (
  `id_ambiente` int NOT NULL,
  `nome_ambiente` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ambiente`
--

INSERT INTO `ambiente` (`id_ambiente`, `nome_ambiente`) VALUES
(1, 'Sala 101'),
(2, 'Sala 102'),
(3, 'MODELAGEM 132'),
(4, 'Sala 108'),
(5, 'Sala 109'),
(6, 'MODA TEC.113'),
(7, 'SENAI LAB.114'),
(8, 'MODA TEC.115'),
(9, 'MODA TEC. 116'),
(10, 'Laboratório 117'),
(11, 'Laboratório 118'),
(12, 'Oficina de Manutenção 121'),
(13, 'Sala 122'),
(14, 'Laboratório de Usinagem 131'),
(15, 'Sala 124'),
(16, 'Laboratório 128'),
(17, 'Laboratório 129'),
(18, 'Laboratório 130'),
(19, 'Laboratório 136'),
(20, 'Laboratório 137'),
(21, 'Laboratório 138'),
(22, 'Oficina de Panificação 139'),
(23, 'Oficina de Panificação 140'),
(24, 'Copa'),
(25, 'Laboratório 135'),
(26, 'Arquivo Inativo'),
(27, 'Diretoria'),
(28, 'Sala de Reuniões'),
(29, 'Sala dos Docentes'),
(30, 'Supervisão Técnica-Pedagógica'),
(31, 'Secretaria Escolar'),
(32, 'Hall de Entrada'),
(33, 'Estacionamento'),
(34, 'Cantina'),
(35, 'Sala 201'),
(36, 'Sala 202'),
(37, 'Sala 203'),
(38, 'Sala 204'),
(39, 'Sala 205'),
(40, 'Sala 206'),
(41, 'Sala 207'),
(42, 'Sala 208'),
(43, 'Sala 209'),
(44, 'BIBLIOTECA'),
(45, 'BANHEIRO (MASC.) OFICINA 121'),
(46, 'BANHEIRO (MASC.) PRÓXIMO A CANTINA'),
(47, 'BANHEIRO (MASC.) USINAGEM 131'),
(48, 'BANHEIRO (MASC.) AO LADO DA COPA'),
(49, 'BANHEIRO (MASC.) 2°PAVIMENTO PRÓX.SALA 209'),
(50, 'BANHEIRO (FEM.) OFICINA 121'),
(51, 'BANHEIRO (FEM.) CORREDOR AO LADO DA ÁREA DE SERVIÇO'),
(52, 'BANHEIRO (FEM.) USINAGEM 131'),
(53, 'BANHEIRO (FEM.) AO LADO DA COPA'),
(54, 'BANHEIRO (FEM.) 2°PAVIMENTO PRÓX.SALA 209');

-- --------------------------------------------------------

--
-- Estrutura para tabela `areas`
--

CREATE TABLE `areas` (
  `id_area` int NOT NULL,
  `nome_area` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `areas`
--

INSERT INTO `areas` (`id_area`, `nome_area`) VALUES
(1, 'Infraestrutura'),
(2, 'Limpeza e Conservação'),
(3, 'Manutenção de Máquinas e Equipamentos'),
(4, 'Tecnologia - Computadores, Rede, Internet, Conversores, Datashow e etc.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividades_extras`
--

CREATE TABLE `atividades_extras` (
  `cod_atividade` int NOT NULL,
  `cod_usuario` int NOT NULL,
  `data` date NOT NULL,
  `carga_inicial` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `carga_final` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `horas` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `atividade` text COLLATE utf8mb4_general_ci NOT NULL,
  `cod_atividade_predef` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividades_predefinidas`
--

CREATE TABLE `atividades_predefinidas` (
  `cod_ativ` int NOT NULL,
  `atividade` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atividades_predefinidas`
--

INSERT INTO `atividades_predefinidas` (`cod_ativ`, `atividade`) VALUES
(1465, 'APOIO À GER. EDU. PROFISSIONAL ATIVIDADE ADMINISTRATIVA'),
(1466, 'APOIO A NUC. INFRA.EDUCACIONAL ATIVIDADE ADMINISTRATIVA'),
(1467, 'APOIO A NUC.PROCESS.EDUCACIONA ATIVIDADE ADMINISTRATIVA'),
(1468, 'APOIO À NÚCLEO PEDAGÓGICO ATIVIDADE ADMINISTRATIVA'),
(1469, 'APOIO À NUC. QUALIDADE EDU. ATIVIDADE ADMINISTRATIVA'),
(1470, 'APOIO AO SESI ATIVIDADE ADMINISTRATIVA'),
(1471, 'APOIO A OUTRAS UNIDADES ATIVIDADE ADMINISTRATIVA'),
(1472, 'APOIO A NUC. EXAMES E CERTIF. ATIVIDADE ADMINISTRATIVA'),
(1473, 'APOIO A NUC. DE EDU.DISTÂNCIA ATIVIDADE ADMINISTRATIVA'),
(1474, 'APOIO AO CENT. DE INOVAÇÃO ATIVIDADE ADMINISTRATIVA'),
(1475, 'APOIO AS ÁREAS CORPORAT. FIEMG ATIVIDADE ADMINISTRATIVA'),
(1476, 'APOIO A PROJ. ESP. EDU.PROF ATIVIDADE ADMINISTRATIVA'),
(1477, 'HORAS EDUCACIONAIS EAD EAD'),
(1478, 'TREINAMENTOS / WORKSHOPS EXTRA-CLASSE'),
(1479, 'CIPA EXTRA-CLASSE'),
(1480, 'CEPA EXTRA-CLASSE'),
(1481, 'MANUTENÇÃO DE MAQ.EQUIPAMENTOS EXTRA-CLASSE'),
(1482, 'MANUTENÇÃO PREDIAL EXTRA-CLASSE'),
(1483, 'ACOMP.ESTÁGIO /PRÁTICA EMPRESA EXTRA-CLASSE'),
(1484, 'ATEND.PROJ. SERV. TEC.INOVAÇÃO EXTRA-CLASSE'),
(1485, 'OUTRAS ATIVIDADES / ED. PROFIS EXTRA-CLASSE'),
(1486, 'AUSÊNCIA LEGAL - INATIVO INATIVO'),
(1487, 'OLIMPÍADA DO CONHECIMENTO OLIMPÍADA DO CONHECIMENTO'),
(1936, 'REUNIÃO DA CIPA'),
(1967, 'SUBTURMAS DISTANCIAMENTO COVID'),
(2065, 'APOIO A OUTRAS UNIDADES'),
(2067, 'APOIO À GERÊNCIA DE OPERAÇÕES'),
(2303, 'CONSULTORIA EM EDUCAÇÃO PROF.'),
(2304, 'APOIO LEGAL A SINDICATO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avisos`
--

CREATE TABLE `avisos` (
  `cod_aviso` int NOT NULL,
  `cod_usuario` int NOT NULL,
  `titulo_aviso` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `detalhes_aviso` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `data_aviso` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `avisos`
--

INSERT INTO `avisos` (`cod_aviso`, `cod_usuario`, `titulo_aviso`, `detalhes_aviso`, `data_aviso`, `status`) VALUES
(1, 1, 'A saúde mental dos colaboradores é fundamental para o sucesso de uma empresa', 'No mundo corporativo atual, a saúde mental dos colaboradores tem se tornado um tema cada vez mais relevante. A pressão do ambiente de trabalho, as metas a serem alcançadas e a competitividade do mercado podem impactar diretamente o bem-estar psicológico dos funcionários. Por isso, é essencial que as empresas se preocupem com a saúde mental de seus colaboradores.', '22/08/2024', 'Publicado'),
(2, 1, 'Espelho de Ponto para Assinatura.', 'O espelho de ponto está disponível para assinatura até dia 06/09/2024.', '02/09/2024', 'Publicado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrossel`
--

CREATE TABLE `carrossel` (
  `cod_car` int NOT NULL,
  `cod_usuario` int NOT NULL,
  `img_car` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `titulo_car` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `desc_car` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carrossel`
--

INSERT INTO `carrossel` (`cod_car`, `cod_usuario`, `img_car`, `titulo_car`, `desc_car`, `status`) VALUES
(7, 1, 'imagens_carrossel/carrossel_6.jpeg', 'Inteligência Artificial', 'Aumente sua prosutividade no trabalho com o uso da IA', 'Publicada'),
(8, 1, 'imagens_carrossel/carrossel_8.jpeg', 'Trilha Expert', 'Desenvolva aplicativos sem saber programar', 'Publicada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int NOT NULL,
  `nome` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `id_instrutor` int DEFAULT NULL,
  `carga_horaria` int NOT NULL,
  `empresa` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `data_inicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nome`, `id_instrutor`, `carga_horaria`, `empresa`, `data_inicio`) VALUES
(82064, 'Administração de Conflitos e Negociação', 14, 16, 'MRS Logística', '2024-09-03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `inconformidades`
--

CREATE TABLE `inconformidades` (
  `id_inconformidade` int NOT NULL,
  `nome_inconformidade` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `inconformidades`
--

INSERT INTO `inconformidades` (`id_inconformidade`, `nome_inconformidade`) VALUES
(1, 'Cadeira quebrada'),
(2, 'Carteira quebrada'),
(3, 'Entupimento'),
(4, 'Fechadura quebrada'),
(5, 'Forro solto'),
(6, 'Goteira'),
(7, 'Interruptor não funciona'),
(8, 'Lâmpada queimada'),
(9, 'Lâmpada piscando'),
(10, 'Mesa quebrada'),
(11, 'Tomada 127 não funciona'),
(12, 'Tomada 220 não funciona'),
(13, 'Vazamento'),
(14, 'Ausência de papel higiênico'),
(15, 'Ausência de papel toalha'),
(16, 'Excesso de lixo'),
(17, 'Piso com resíduos orgânicos'),
(18, 'Piso molhado'),
(19, 'Presença de insetos'),
(20, 'Presença de poeira'),
(21, 'Restos de alimento'),
(22, 'Ausência de conversores HDMI, VGA'),
(23, 'Computador não liga'),
(24, 'Data Show não liga'),
(25, 'Data Show piscando'),
(26, 'Data Show com projeção azulada'),
(27, 'Data Show com ruído excessivo'),
(28, 'Falta de internet'),
(29, 'Impressora não funciona'),
(30, 'Mouse não funciona'),
(31, 'Problemas de softwares'),
(32, 'Teclado não funciona');

-- --------------------------------------------------------

--
-- Estrutura para tabela `matricula`
--

CREATE TABLE `matricula` (
  `matricula` int NOT NULL,
  `nome_aluno` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `cidade_nascimento` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mae` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pai` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cor` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_civil` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rg` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orgao_emissor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_endereco` int NOT NULL,
  `complemento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cep` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `escolaridade` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `escola_origem` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deficiencia` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `curso` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `matricula`
--

INSERT INTO `matricula` (`matricula`, `nome_aluno`, `data_nascimento`, `cidade_nascimento`, `mae`, `pai`, `cor`, `sexo`, `estado_civil`, `rg`, `orgao_emissor`, `cpf`, `endereco`, `numero_endereco`, `complemento`, `bairro`, `cidade`, `cep`, `email`, `telefone`, `escolaridade`, `escola_origem`, `deficiencia`, `empresa`, `data_cadastro`, `curso`) VALUES
(23, 'Pricila Almeida Ferreira', '1995-08-08', 'Santos Dumont - MG', 'Rita de Cassia Almeida', 'Maurilio dos Santos Ferreira', 'branca', 'feminino', 'Casado', 'MG16904628', 'SSP - MG', '08285133680', 'Rua Ângelo Corradini ', 400, '', 'Vila Nambi', 'Jundiaí', '13219071', 'pricila.ferreira@mrs.com.br', '32991211467', 'Superior Completo', 'Universidade Federal de Juiz de Fora', 'não', 'MRS Logística', '2024-09-03 13:37:56', 82064),
(24, 'thiago magno barbosa damascneo', '1999-09-27', 'barbacena', 'clea de assuncao barbosa damasceno', 'Paulo sergio damasceno', 'branca', 'masculino', 'Solteiro', '20156483', 'PCMG', '13500218652', 'Pedro rogerio araujo', 120, '', 'sao cristovao', 'barbacena', '36201611', 'thgmagno@gmaill.com', '32988179680', 'superior incompleto', 'UFSJ', 'nao', 'MRS', '2024-09-03 13:38:15', 82064),
(25, 'Osmane Alves Laguna', '1977-01-26', 'Montes Claros-MG', 'Cleyde Raquel Alves Laguna', 'Osmar Dobscha Laguna', 'branca', 'masculino', 'Solteiro', 'MG 6.616.058', 'SSPMG', '887.987.126-91', 'Rua Mucuri', 330, 'casa', 'Floresta', 'BELO HORIZONTE', '30150190', 'osmane.laguna@mrs.com.br', '31997359112', 'Pós-graduado', 'MRS', 'MG', 'MRS', '2024-09-03 13:38:52', 82064),
(26, 'JOAO GABRIEL FERREIRA DOS SANTOS', '1998-11-17', 'BARRA DO PIRAÍ', 'ALESSANDRA FERREIRA DOS SANTOS', 'EDUARDO ANDRADE DOS SANTOS', 'parda', 'masculino', 'Casado', '250248614', 'DETRAN RJ', '185.236.227-80', 'RUA FRANCISCO PEGAS', 613, '', 'AREAL', 'BARRA DO PIRAÍ', '27150130', 'joao.fsantos@mrs.com.br', '24992943812', 'SUPERIOR CURSANDO', 'MRS', 'NÃO', 'MRS LOGÍSTICA', '2024-09-03 13:38:53', 82064),
(27, 'Alice Cristina da Silva', '1996-08-14', 'Juiz de Fora', 'Lucia Helena Ruffato', 'Paulo Sergio da Silva', 'branca', 'feminino', 'Solteiro', '18.850.438', 'PCMG', '094.609.486-18', 'Rua Pedro Antônio da Conceição', 188, '', 'Santa Isabel', 'Juiz de Fora', '36087-754', 'alice.silva@mrs.com.br', '32998207514', 'Superior Completo', 'MRS logística', 'Sim', 'MRS logística ', '2024-09-03 13:38:55', 82064),
(28, 'Pedro Henrique Rezende Melo', '1997-09-21', 'Conselheiro Lafaiete', 'Lilian Cristina de Rezende ', 'Marcelo Junior de Melo', 'branca', 'masculino', 'Solteiro', 'MG 18.579.320', 'PCMG', '08703317609', 'Avenida Presidente Costa e Silva', 2316, '108', 'São Pedro', 'Juiz de Fora ', '36037000', 'pedro.henrique@mrs.com.br', '31993731486', 'Superior completo', 'UFJF', 'Não', 'MRS', '2024-09-03 13:39:41', 82064),
(29, 'Milene Pereira Toledo', '2001-05-18', 'Guarani', 'Rosana Aparecida Pereira Pinto Toledo', 'Paulo da Silva Toledo', 'parda', 'feminino', 'Solteiro', 'MG-20471920', 'PM', '140.232.556-88', 'Rua Santo Antônio ', 1465, 'Ap 209', 'Centro', 'Juiz de Fora', '36016211', 'milene.toledo@mrs.com.br', '32999848161', 'Ensino Superior em andamento', 'MRS Logística', 'Não', 'MRS Logística', '2024-09-03 13:39:59', 82064),
(30, 'Bianca Wendy do Nascimento', '1997-12-12', 'Mauá', 'Maria Cristina Martins de lacerda', 'Joziel Barbosa do Nascimento', 'parda', 'feminino', 'Casado', '385683635', 'SSP', '44845266890', 'Rua barão de resende', 51, 'AP 205', 'Ipiranga', 'São Paulo', '04210050', 'bianca.wendy@mrs.com.br', '11952050612', 'Superior completo', 'Estácio', 'Não', 'MRS Logistica', '2024-09-03 13:40:21', 82064),
(31, 'ANTONIO CARLOS FERREIRA SOARES', '1963-10-29', 'MENDES-RJ', 'AGNELLO GOMES SOARES', 'YOLANDA DE PAULA FERREIRA', 'branca', 'masculino', 'Casado', '07340750-4', 'DETRAN-RJ', '79761054772', 'RUA B', 335, '', 'SANTA ROSA', 'PIRAI-RJ', '27175000', 'antonio.soares@mrs.com.br', '24999831449', 'ENSINO SUPERIOR', 'UNIVERSIDADE GERALDO DI BIASE', 'NÃO', 'MRS LOGÍSITICA', '2024-09-03 13:44:31', 82064),
(32, 'Rodrigo Marcos Ferreira Rodrigues', '1989-10-21', 'Rio de Janeiro', 'Iraci das Merces Ferreira Rodrigues', 'Darci Rodrigues', 'branca', 'masculino', 'Casado', '172303', 'OAB/RJ', '05710415740', 'Rua Mamoré', 205, '', 'São Mateus', 'Juiz de Fora', '36025280', 'rodrigo.marcos@mrs.com.br', '32984226757', 'Superior', 'Estácio de Sá', 'Não', 'MRS Logística S.A.', '2024-09-03 13:45:08', 82064),
(33, 'LARISSA GOMES DE AZEVEDO', '2001-08-06', 'POÇÕES - BA', 'Ivonete dos Santos Gomes', 'Lafaiete Rodrigues de Azevedo', 'parda', 'feminino', 'Solteiro', '2196491462', 'SSP', '07246010580', 'Rua Leopoldo Ruzicka', 15, '', 'Jardim Germânia', 'São Paulo', '05848000', 'larissa.azevedo@mrs.com.br', '11987684815', 'Superior Completo', '-', 'Não', 'MRS Logística', '2024-09-03 14:12:32', 82064),
(34, 'ALLYSSON FREITAS', '1978-12-26', 'SANTOS DUMONT', 'MARIA LUCIA', 'AMAURI', 'PARDA', 'MASCULINO', 'CASADO', 'MG10457890', 'PCMG', '01172718610', 'TESTE', 123, 'CASA', 'CABANGU', 'SANTOS DUMONT', '36240000', 'ALFREITAS@FIEMG.COM.BR', '32991391960', 'TESTE', 'TESTE', 'NãO', 'SENAI', '2024-09-03 16:01:24', 82064);

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `cod_noticia` int NOT NULL,
  `cod_usuario` int NOT NULL,
  `nome` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `img_banner` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img_noticia` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `titulo` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `sub_titulo` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `resumo_noticia` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `materia` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `data` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`cod_noticia`, `cod_usuario`, `nome`, `img_banner`, `img_noticia`, `titulo`, `sub_titulo`, `resumo_noticia`, `materia`, `data`, `status`) VALUES
(7, 1, 'Albert Figueiredo da Costa', 'imagens_noticia/TESTE/banner_1.jpeg', 'imagens_noticia/TESTE/principal_1.jpeg', 'TESTE', 'testado', '<p>testadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestado</p>\r\n', '<p>testadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestado</p>\r\n\r\n<p>testadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestado</p>\r\n\r\n<p>testadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestado</p>\r\n\r\n<p>testadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestadotestado</p>\r\n', '08/08/2024', 'Publicada'),
(8, 1, 'Albert Figueiredo da Costa', 'imagens_noticia/Notícia 1/banner_8.jpeg', 'imagens_noticia/Notícia 1/principal_8.jpeg', 'Notícia 1', 'Teste de inserção de notícias', '<p>O SESI MG est&aacute; firmemente comprometido em promover a Seguran&ccedil;a e Sa&uacute;de na Ind&uacute;stria por meio da Seguran&ccedil;a e Sa&uacute;de do Trabalho (SST) e a Promo&ccedil;&atilde;o da Sa&uacute;de (PS).</p>\r\n', '<p>Neste cen&aacute;rio, a vis&atilde;o do SESI MG &eacute; estabelecer um padr&atilde;o de gest&atilde;o em SST e PS que seja eficaz e adaptado &agrave;s necessidades da ind&uacute;stria moderna. Nosso objetivo &eacute; ajudar as empresas a cultivar ambientes de trabalho cada vez mais seguros e saud&aacute;veis, aumentando a aten&ccedil;&atilde;o e o cuidado com os trabalhadores e seus dependentes, fomentando o bem-estar geral e, ao mesmo tempo, otimizando os custos empresariais.</p>\r\n', '02/09/2024', 'Não Publicada'),
(9, 1, 'Albert Figueiredo da Costa', 'imagens_noticia/O Mundo em 2050: Avanços Tecnológicos e Sustentabilidade em Alta/banner_9.jpeg', 'imagens_noticia/O Mundo em 2050: Avanços Tecnológicos e Sustentabilidade em Alta/principal_9.jpeg', 'O Mundo em 2050: Avanços Tecnológicos e Sustentabilidade em Alta', 'No futuro de 2050, o mundo está passando por transformações radicais. A tecnologia e a sustentabilidade estão no centro das mudanças, e as cidades estão se adaptando para criar um ambiente mais verde e eficiente. ', '<p>Em 2050, o <a href=\"https://www.google.com.br\">futuro</a> &eacute; marcado por inova&ccedil;&otilde;es tecnol&oacute;gicas que priorizam a sustentabilidade e a qualidade de vida. Cidades adaptativas, sistemas de transporte avan&ccedil;ados e m&eacute;todos agr&iacute;colas sustent&aacute;veis s&atilde;o agora uma realidade, mostrando um mundo que est&aacute; n&atilde;o apenas enfrentando os desafios do presente, mas tamb&eacute;m se preparando para um futuro mais verde e eficiente.</p>\r\n', '<p>Em 2050, o mundo est&aacute; irreconhec&iacute;vel para quem viveu nas d&eacute;cadas anteriores. Avan&ccedil;os tecnol&oacute;gicos e um compromisso renovado com a sustentabilidade transformaram a maneira como vivemos, trabalhamos e interagimos com nosso ambiente. Esta reportagem explora algumas das inova&ccedil;&otilde;es mais not&aacute;veis que definem nossa era.</p>\r\n\r\n<p>Os ve&iacute;culos aut&ocirc;nomos, movidos a energia el&eacute;trica, s&atilde;o agora a norma nas grandes cidades. Esses ve&iacute;culos n&atilde;o apenas oferecem uma experi&ecirc;ncia de viagem mais segura e personalizada, mas tamb&eacute;m reduzem significativamente as emiss&otilde;es de carbono. As c&aacute;psulas a&eacute;reas, vis&iacute;veis em nossas imagens, se movem suavemente por pistas elevadas, conectando diferentes &aacute;reas urbanas sem a necessidade de congestionamentos.</p>\r\n\r\n<p>A agricultura vertical revolucionou a produ&ccedil;&atilde;o de alimentos, permitindo o cultivo de produtos frescos em meio &agrave; urbaniza&ccedil;&atilde;o. As fazendas verticais, como mostrado na imagem, ocupam edif&iacute;cios e s&atilde;o iluminadas por LEDs que imitam a luz solar. Essa tecnologia n&atilde;o s&oacute; economiza espa&ccedil;o, mas tamb&eacute;m reduz a pegada de carbono associada ao transporte de alimentos, tornando as cidades mais autossuficientes.</p>\r\n\r\n<p>A integra&ccedil;&atilde;o da intelig&ecirc;ncia artificial em nossas casas trouxe um novo n&iacute;vel de conveni&ecirc;ncia e efici&ecirc;ncia. Os assistentes rob&oacute;ticos, que ajudam nas tarefas di&aacute;rias e interagem com os moradores, s&atilde;o uma vis&atilde;o comum nas resid&ecirc;ncias modernas. Esses dispositivos s&atilde;o programados para aprender e se adaptar &agrave;s necessidades dos usu&aacute;rios, oferecendo uma assist&ecirc;ncia personalizada e tornando o cotidiano mais tranquilo e organizado.</p>\r\n\r\n<p>O compromisso global com a sustentabilidade &eacute; evidenciado pelo aumento da gera&ccedil;&atilde;o de energia renov&aacute;vel. Campos de turbinas e&oacute;licas e pain&eacute;is solares, como o mostrado na imagem, agora dominam as paisagens. Essas instala&ccedil;&otilde;es s&atilde;o parte de um esfor&ccedil;o cont&iacute;nuo para reduzir nossa depend&ecirc;ncia de combust&iacute;veis f&oacute;sseis e combater as mudan&ccedil;as clim&aacute;ticas. A recupera&ccedil;&atilde;o de &aacute;reas degradadas para a instala&ccedil;&atilde;o dessas tecnologias &eacute; um passo importante na cria&ccedil;&atilde;o de um futuro mais verde.</p>\r\n\r\n<p>O futuro, como retratado em 2050, &eacute; uma combina&ccedil;&atilde;o impressionante de tecnologia avan&ccedil;ada e consci&ecirc;ncia ambiental. As inova&ccedil;&otilde;es que est&atilde;o moldando nosso mundo n&atilde;o apenas melhoram a qualidade de vida, mas tamb&eacute;m ajudam a enfrentar desafios globais significativos. &Agrave; medida que continuamos a avan&ccedil;ar, o equil&iacute;brio entre desenvolvimento tecnol&oacute;gico e preserva&ccedil;&atilde;o ambiental ser&aacute; crucial para garantir um futuro sustent&aacute;vel para todos.</p>\r\n', '03/09/2024', 'Publicada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_servico`
--

CREATE TABLE `ordem_servico` (
  `id_os` int NOT NULL,
  `solicitante` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ambiente` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inconformidade` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data_solicitacao` date DEFAULT NULL,
  `observacao` text COLLATE utf8mb4_general_ci NOT NULL,
  `upload` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_servico`
--

INSERT INTO `ordem_servico` (`id_os`, `solicitante`, `area`, `ambiente`, `inconformidade`, `data_solicitacao`, `observacao`, `upload`, `id_usuario`) VALUES
(58, 'Albert Figueiredo da Costa', 'Infraestrutura', 'Laboratório 135', 'Lâmpada queimada', '2024-09-02', 'Lâmpada queimada próximo ao rack.', NULL, 1),
(59, 'Allysson Freitas', 'Infraestrutura', 'Laboratório 135', 'Goteira', '2024-09-02', 'teste', NULL, 4),
(60, 'Allysson Freitas', 'Infraestrutura', 'Laboratório 135', 'Goteira', '2024-09-02', 'iuiuhi', NULL, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao`
--

CREATE TABLE `solicitacao` (
  `cod_sol` int NOT NULL,
  `date_sol` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inicio_comp` date NOT NULL,
  `final_comp` date NOT NULL,
  `turno` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `horas` int NOT NULL,
  `colaborador_cod_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `perfil` enum('gestor','colaborador') NOT NULL DEFAULT 'colaborador',
  `data_admissao` date NOT NULL,
  `gestor_cod_usuario` int DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nome`, `matricula`, `cpf`, `celular`, `perfil`, `data_admissao`, `gestor_cod_usuario`, `email`, `senha`) VALUES
(1, 'Albert Figueiredo da Costa', '', '', '(32) 98821-6336', 'gestor', '2000-01-01', 3, 'insight.tecnologiadainformacao@gmail.com', '123456'),
(3, 'André Leandro Fonseca Pimentel', '09103404', '81687036691', '(32)98811-5983', 'gestor', '2007-04-02', 3, 'apimentel@fiemg.com.br', '123456'),
(4, 'Allysson Freitas', '09107720', '01172719610', '(32) 99139-1960', 'colaborador', '2013-04-13', 1, 'alfreitas@fiemg.com.br', '#123456'),
(6, 'Carlos Eduardo Bogea Dias', '09109822', '12345678911', '32922223333', 'colaborador', '2020-02-17', 1, 'cbogea@fiemg.com.br', '123456'),
(14, 'Paula Almeida de Oliveira Patrocínio', '09110945', '01483202607', '32991440629', 'colaborador', '2018-10-15', 1, 'p.almeida@fiemg.com.br', '728014'),
(15, 'Liliane Aparecida Borges de Oliveira', '09104350', '06386162633', '(32) 99145-4903', 'gestor', '2006-07-07', 3, 'lboliveira@fiemg.com.br', '123456'),
(16, 'Sandra Dos Anjos Batista', '09105506', '05646378664', '(31) 99861-4948', 'gestor', '2010-09-13', 3, 'sdbatista@fiemg.com.br', '123456'),
(17, 'Ligia Sousa Oliveira Brito', '09110606', '06859226692', '(32) 98895-7872', 'gestor', '2017-08-14', 3, 'lsoliveira@fiemg.com.br', '123456'),
(18, 'TATIANA APARECIDA DA SILVA', '9107168', '06288500690', '32998317962', 'gestor', '2012-07-23', 15, 'tatiana.aparecida@fiemg.com.br', '123456');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`id_ambiente`);

--
-- Índices de tabela `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`);

--
-- Índices de tabela `atividades_extras`
--
ALTER TABLE `atividades_extras`
  ADD PRIMARY KEY (`cod_atividade`),
  ADD KEY `cod_atividade_extra` (`cod_atividade_predef`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Índices de tabela `atividades_predefinidas`
--
ALTER TABLE `atividades_predefinidas`
  ADD PRIMARY KEY (`cod_ativ`);

--
-- Índices de tabela `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`cod_aviso`);

--
-- Índices de tabela `carrossel`
--
ALTER TABLE `carrossel`
  ADD PRIMARY KEY (`cod_car`);

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `id_instrutor` (`id_instrutor`);

--
-- Índices de tabela `inconformidades`
--
ALTER TABLE `inconformidades`
  ADD PRIMARY KEY (`id_inconformidade`);

--
-- Índices de tabela `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `curso` (`curso`);

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`cod_noticia`);

--
-- Índices de tabela `ordem_servico`
--
ALTER TABLE `ordem_servico`
  ADD PRIMARY KEY (`id_os`),
  ADD KEY `id_usuario_fk` (`id_usuario`) USING BTREE;

--
-- Índices de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD PRIMARY KEY (`cod_sol`),
  ADD KEY `fk_solicitacao_colaborador_idx` (`colaborador_cod_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_gestor` (`gestor_cod_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `id_ambiente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `areas`
--
ALTER TABLE `areas`
  MODIFY `id_area` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `atividades_extras`
--
ALTER TABLE `atividades_extras`
  MODIFY `cod_atividade` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `atividades_predefinidas`
--
ALTER TABLE `atividades_predefinidas`
  MODIFY `cod_ativ` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2305;

--
-- AUTO_INCREMENT de tabela `avisos`
--
ALTER TABLE `avisos`
  MODIFY `cod_aviso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `carrossel`
--
ALTER TABLE `carrossel`
  MODIFY `cod_car` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89552;

--
-- AUTO_INCREMENT de tabela `inconformidades`
--
ALTER TABLE `inconformidades`
  MODIFY `id_inconformidade` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `matricula`
--
ALTER TABLE `matricula`
  MODIFY `matricula` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `cod_noticia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `ordem_servico`
--
ALTER TABLE `ordem_servico`
  MODIFY `id_os` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `cod_sol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atividades_extras`
--
ALTER TABLE `atividades_extras`
  ADD CONSTRAINT `atividades_extras_ibfk_1` FOREIGN KEY (`cod_atividade_predef`) REFERENCES `atividades_predefinidas` (`cod_ativ`),
  ADD CONSTRAINT `atividades_extras_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`),
  ADD CONSTRAINT `atividades_extras_ibfk_3` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`);

--
-- Restrições para tabelas `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD CONSTRAINT `fk_solicitacao_Usuarios` FOREIGN KEY (`colaborador_cod_usuario`) REFERENCES `usuarios` (`cod_usuario`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_gestor` FOREIGN KEY (`gestor_cod_usuario`) REFERENCES `usuarios` (`cod_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
