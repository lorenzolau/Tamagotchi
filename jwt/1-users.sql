CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `name` (`name`);

ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
  (1, 'Jon Doe', 'jon@doe.com', '$2y$10$5S0BORM0dC/pVrddltxbg.Fa5EBa5zZDXxNhL5Jt57bCi1aFZpcee');