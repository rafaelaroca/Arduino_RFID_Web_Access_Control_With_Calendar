CREATE TABLE `cards` (
  `id` int(11) DEFAULT NULL,
  `card` varchar(30) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `dia_semana` int(11) DEFAULT NULL,
  `expiracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `local` varchar(100) DEFAULT NULL,
  `horario_ini` varchar(20) DEFAULT NULL,
  `horario_fim` varchar(20) DEFAULT NULL
);

CREATE TABLE `logs` (
  `id` int(11) DEFAULT NULL,
  `instante` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cartao` varchar(30) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL
);
