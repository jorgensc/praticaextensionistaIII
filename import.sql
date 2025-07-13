-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS `coloratto_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados
USE `coloratto_db`;

-- Tabela para Usuários (para login)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Para armazenar o hash da senha
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `role` VARCHAR(20) NOT NULL DEFAULT 'user', -- 'admin', 'user'
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir um usuário administrador padrão (senha: admin123)
-- Lembre-se de sempre gerar o hash da senha em produção!
-- O hash abaixo é para 'admin123' usando password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO `users` (`username`, `password`, `email`, `role`) VALUES
('admin', '$2y$10$wN9iL6D8.r7.R2xK5g1.1uC9v.L0p5.M4jX.g4V0b4V2/Q.t2L3S3', 'admin@coloratto.com.br', 'admin');


-- Tabela para Serviços
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `price_range` VARCHAR(50),
  `image_path` VARCHAR(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados de exemplo para Serviços (poderiam ser inseridos via CRUD)
INSERT INTO `services` (`name`, `description`, `price_range`, `image_path`) VALUES
('Pintura Interna', 'Transformamos seus ambientes internos com cores vibrantes e acabamentos impecáveis. Desde paredes a tetos, garantimos um serviço limpo e de alta qualidade.', 'A partir de R$ 500', 'assets/img/servicos/produto1.jpg'),
('Pintura Externa', 'Proteção e beleza para o exterior de sua propriedade. Utilizamos tintas resistentes às intempéries, garantindo durabilidade e um visual renovado.', 'A partir de R$ 800', 'assets/img/servicos/produto2.jpg'),
('Restauração de Fachadas', 'Recuperamos a beleza original da sua fachada, corrigindo imperfeições e aplicando acabamentos que valorizam seu imóvel.', 'Sob Consulta', 'assets/img/servicos/produto3.jpg'),
('Pintura de Grades e Portões', 'Renovamos a aparência de grades, portões e janelas, aplicando tintas protetoras que evitam ferrugem e desgaste.', 'A partir de R$ 200', 'assets/img/servicos/produto4.jpg'),
('Texturas e Efeitos', 'Crie ambientes únicos com texturas e efeitos decorativos. Explore diversas opções para dar um toque especial às suas paredes.', 'A partir de R$ 600', 'assets/img/servicos/produto5.jpg'),
('Pintura Comercial', 'Serviços de pintura para estabelecimentos comerciais. Ambientes profissionais e convidativos que impactam positivamente seus clientes.', 'Sob Consulta', 'assets/img/servicos/produto6.jpg');


-- Tabela para Clientes (Testemunhos/Projetos)
CREATE TABLE IF NOT EXISTS `clients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `image_path` VARCHAR(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados de exemplo para Clientes (poderiam ser inseridos via CRUD)
INSERT INTO `clients` (`name`, `description`, `image_path`) VALUES
('Residência Família Silva', 'Pintura interna e externa completa, com revitalização de fachadas. Projeto concluído em 2023.', 'assets/img/clientes/cliente1.jpg'),
('Escritório Central LTDA.', 'Renovação da pintura de escritórios e áreas comuns. Foco em cores corporativas e durabilidade.', 'assets/img/clientes/cliente2.jpg'),
('Restaurante Sabor da Vila', 'Aplicação de texturas e cores para criar um ambiente acolhedor e moderno para os clientes.', 'assets/img/clientes/cliente3.jpg'),
('Condomínio Recanto Verde', 'Pintura de áreas comuns, halls e grades do condomínio. Manutenção preventiva e estética.', 'assets/img/clientes/cliente4.jpg');


-- Tabela para Orçamentos Solicitados (do formulário de orçamento)
CREATE TABLE IF NOT EXISTS `budgets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20),
  `service_type` VARCHAR(50) NOT NULL,
  `message` TEXT,
  `status` VARCHAR(20) NOT NULL DEFAULT 'pending', -- pending, contacted, approved, rejected
  `requested_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Tabela para Contatos com Desenvolvedores (do formulário de contato)
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(255),
  `message` TEXT,
  `sent_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;