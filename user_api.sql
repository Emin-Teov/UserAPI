SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(6) NOT NULL,
  `token` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `tokens` (`id`, `type`, `token`) VALUES
(1, 'insert', '75946c2a623bbb52831d3b0a4d94e435'),
(2, 'update', '405e6bd16aca6c962c219331f6a8c154'),
(3, 'delete', '5e4ab0654dda95cf9d58b08eb9b55a78');


CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(55) NOT NULL,
  `surname` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;