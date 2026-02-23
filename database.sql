CREATE DATABASE IF NOT EXISTS `codei` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `codei`;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'customer',
  `avatar` varchar(255) DEFAULT NULL,
  `initials` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `role`, `avatar`, `initials`) VALUES
(1, 'Alex Carter', 'admin@nexgen.com', 'admin', 'https://i.pravatar.cc/150?img=11', 'AC'),
(2, 'Sarah Jenkins', 'sarah@example.com', 'customer', 'https://i.pravatar.cc/150?img=33', 'SJ'),
(3, 'Michael Chang', 'michael@example.com', 'customer', 'https://i.pravatar.cc/150?img=68', 'MC'),
(4, 'Emma Roberts', 'emma@example.com', 'customer', 'https://i.pravatar.cc/150?img=47', 'ER'),
(5, 'David Johnson', 'david@example.com', 'customer', NULL, 'DJ'),
(6, 'John Doe', 'john@example.com', 'customer', 'https://i.pravatar.cc/150?img=32', 'JD'),
(7, 'Jane Smith', 'jane@example.com', 'customer', 'https://i.pravatar.cc/150?img=12', 'JS'),
(8, 'Alice Brown', 'alice@example.com', 'customer', 'https://i.pravatar.cc/150?img=43', 'AB'),
(9, 'Bob White', 'bob@example.com', 'customer', 'https://i.pravatar.cc/150?img=54', 'BW');

-- Table structure for table `transactions`
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Completed','Processing','Failed') NOT NULL DEFAULT 'Processing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transaction_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `transactions`
INSERT INTO `transactions` (`transaction_id`, `user_id`, `amount`, `status`, `created_at`) VALUES
('#TRX-849170', 5, 120.00, 'Failed', '2026-10-23 09:00:00'),
('#TRX-849182', 4, 3400.00, 'Completed', '2026-10-23 11:15:00'),
('#TRX-849195', 3, 450.50, 'Processing', '2026-10-24 03:42:00'),
('#TRX-849201', 2, 1200.00, 'Completed', '2026-10-24 04:54:00');
