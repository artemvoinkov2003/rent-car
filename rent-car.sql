-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 05 2026 г., 21:26
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rent-car`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `car_id`, `user_id`, `start_date`, `end_date`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 3, '2026-03-14 00:00:00', '2026-03-16 00:00:00', 24000.00, 'completed', '2026-03-14 09:36:03', '2026-03-14 16:04:29'),
(2, 8, 3, '2026-03-15 00:00:00', '2026-03-20 00:00:00', 100000.00, 'confirmed', '2026-03-14 09:37:20', '2026-03-14 14:42:39'),
(3, 118, 2, '2026-05-05 00:00:00', '2026-05-10 00:00:00', 240000.00, 'confirmed', '2026-05-05 09:04:10', '2026-05-05 09:38:51'),
(4, 130, 2, '2026-05-05 00:00:00', '2026-05-06 00:00:00', 52000.00, 'pending', '2026-05-05 09:40:02', '2026-05-05 09:40:02');

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year` int(4) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `body_type` enum('sedan','hatchback','suv','coupe','convertible','wagon') DEFAULT NULL,
  `transmission` enum('manual','automatic','robotic','variator') DEFAULT NULL,
  `engine_volume` decimal(3,1) DEFAULT NULL,
  `fuel_type` enum('petrol','diesel','electric','hybrid') DEFAULT NULL,
  `drive_type` enum('rear','front','all') DEFAULT NULL,
  `fuel_consumption` decimal(3,1) DEFAULT NULL,
  `payment_options` set('cash','card','transfer') DEFAULT NULL,
  `insurance_options` set('basic','full') DEFAULT NULL,
  `license_plate` varchar(20) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `price_per_hour` decimal(10,2) DEFAULT NULL,
  `deposit` decimal(10,2) DEFAULT NULL,
  `status` enum('available','booked','repair') NOT NULL DEFAULT 'available',
  `category` enum('premium','sport') NOT NULL DEFAULT 'premium',
  `description` text DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `owner_id`, `model_id`, `year`, `color`, `body_type`, `transmission`, `engine_volume`, `fuel_type`, `drive_type`, `fuel_consumption`, `payment_options`, `insurance_options`, `license_plate`, `mileage`, `price_per_day`, `price_per_hour`, `deposit`, `status`, `category`, `description`, `views`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2021, 'Белый', 'sedan', 'automatic', 2.5, 'petrol', 'front', NULL, 'cash', 'basic', 'А123ВВ777', 45000, 3500.00, 250.00, 5000.00, 'available', 'premium', 'Комфортный седан', 0, '2026-03-13 14:03:34', '2026-03-13 15:58:34'),
(2, 2, 2, 2019, 'Чёрный', 'suv', 'automatic', 4.0, 'diesel', 'rear', NULL, 'card', 'full', 'В456АВ777', 80000, 6000.00, 400.00, 10000.00, 'available', 'premium', 'Надёжный внедорожник', 0, '2026-03-13 14:03:34', '2026-04-30 06:42:39'),
(3, 2, 3, 2022, 'Золотой', 'coupe', 'automatic', 3.0, 'petrol', 'rear', NULL, 'transfer', 'full', 'С789АВ777', 20000, 8000.00, 500.00, 15000.00, 'available', 'premium', 'Премиальный SUV', 0, '2026-03-13 14:03:34', '2026-04-30 06:40:05'),
(4, 2, 4, 2021, 'Красный', 'coupe', 'automatic', 3.0, 'petrol', 'rear', NULL, 'card', 'basic', 'М111ММ777', 15000, 12000.00, 800.00, 20000.00, 'available', 'premium', 'Спортивное купе', 0, '2026-03-13 14:03:34', '2026-03-13 16:43:43'),
(5, 2, 5, 2018, 'Серебристый', 'sedan', 'automatic', 2.0, 'petrol', 'front', NULL, 'transfer', 'full', 'К222КК777', 90000, 4000.00, 300.00, 7000.00, 'available', 'premium', 'Бизнес-класс', 0, '2026-03-13 14:03:34', '2026-03-13 15:58:53'),
(6, 2, 6, 2020, 'Красный', 'suv', 'robotic', 0.0, 'electric', 'front', NULL, 'cash', 'basic', 'О333ОО777', 10000, 8000.00, 1000.00, 30000.00, 'available', 'premium', 'Спорткар', 0, '2026-03-13 14:03:34', '2026-04-30 06:49:06'),
(7, 2, 7, 2017, 'Чёрный', 'sedan', 'automatic', 2.0, 'petrol', 'front', NULL, 'transfer', 'basic', 'Т444ТТ777', 120000, 3000.00, 200.00, 5000.00, 'available', 'premium', 'Немецкий седан', 0, '2026-03-13 14:03:34', '2026-03-13 15:59:02'),
(8, 2, 8, 2020, 'Серый', 'coupe', 'robotic', 5.2, 'petrol', 'rear', NULL, 'card', 'full', 'У555УУ777', 5000, 20000.00, 1500.00, 40000.00, 'available', 'premium', 'Суперкар', 0, '2026-03-13 14:03:34', '2026-03-13 16:43:57'),
(9, 2, 9, 2021, 'Белый', 'sedan', 'manual', 1.6, 'petrol', 'front', NULL, 'cash', 'full', 'Х666ХХ777', 30000, 1500.00, 100.00, 3000.00, 'available', 'premium', 'Бюджетный седан', 0, '2026-03-13 14:03:34', '2026-03-13 15:59:11'),
(10, 2, 10, 2020, 'Серый', 'sedan', 'manual', 1.6, 'petrol', 'front', NULL, 'transfer', 'basic', 'Ч777ЧЧ777', 40000, 1200.00, 80.00, 2000.00, 'available', 'premium', 'Народный автомобиль', 0, '2026-03-13 14:03:34', '2026-03-13 15:59:15'),
(11, 2, 11, 2020, 'Серебристый', 'sedan', 'automatic', 1.5, 'petrol', 'front', 6.5, 'card,transfer', 'basic', 'Х777АА123', 35000, 2500.00, 200.00, 5000.00, 'available', 'premium', 'Компактный и экономичный седан с современным дизайном. Идеален для города.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:54'),
(12, 2, 12, 2019, 'Темно-синий', 'sedan', 'automatic', 2.0, 'petrol', 'front', 7.2, 'cash,card', 'full', 'В888ВВ123', 52000, 3500.00, 300.00, 7000.00, 'available', 'premium', 'Просторный бизнес-седан с комфортной подвеской и богатым оснащением.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:05'),
(13, 2, 13, 2018, 'Белый', 'sedan', 'manual', 1.6, 'petrol', 'front', 7.8, 'cash,transfer', 'basic', 'С999СС777', 68000, 2000.00, 150.00, 4000.00, 'available', 'premium', 'Классический Lancer: надёжный, динамичный, с характерным агрессивным дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:14'),
(14, 2, 14, 2021, 'Красный', 'suv', 'automatic', 1.5, 'petrol', 'front', 6.9, 'card', 'basic', 'Т111ТТ777', 12000, 4000.00, 300.00, 8000.00, 'available', 'premium', 'Кроссовер с ярким дизайном и отличной управляемостью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:18'),
(15, 2, 15, 2020, 'Чёрный', 'sedan', 'automatic', 2.0, 'petrol', 'all', 7.5, 'cash,card', 'full', 'У222УУ777', 28000, 3200.00, 250.00, 6000.00, 'available', 'premium', 'Полноприводный седан с отличной устойчивостью и безопасностью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:26'),
(16, 2, 16, 2017, 'Серый', 'sedan', 'automatic', 2.5, 'petrol', 'all', 8.0, 'transfer', 'basic', 'Ф333ФФ777', 95000, 2800.00, 200.00, 5000.00, 'available', 'premium', 'Комфортный полноприводный седан для дальних поездок.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:31'),
(17, 2, 17, 2021, 'Белый', 'sedan', 'automatic', 2.5, 'hybrid', 'front', 4.5, 'cash,card,transfer', 'full', 'А666А777', 15000, 8000.00, 600.00, 15000.00, 'available', 'premium', 'Роскошный гибридный седан с тихим салоном и экономичным расходом.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:36'),
(18, 2, 18, 2019, 'Красный', 'sedan', 'automatic', 2.0, 'petrol', 'rear', 8.2, 'card', 'basic', 'Р555РР777', 42000, 6500.00, 500.00, 12000.00, 'available', 'premium', 'Спортивный седан с задним приводом и отточенной управляемостью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:27:44'),
(19, 2, 19, 2022, 'Жёлтый', 'coupe', 'automatic', 2.3, 'petrol', 'rear', 9.0, 'cash,card', 'full', 'С666СС777', 8000, 10000.00, 800.00, 20000.00, 'available', 'premium', 'Культовый американский масл-кар с мощным турбомотором и задним приводом.', 0, '2026-04-30 07:19:22', '2026-04-30 07:27:50'),
(20, 2, 20, 2020, 'Синий', 'hatchback', 'automatic', 1.5, 'petrol', 'front', 6.0, 'transfer', 'basic', 'А777АА777', 34000, 2200.00, 180.00, 4000.00, 'available', 'premium', 'Популярный хэтчбек с хорошей управляемстью и экономичностью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:52'),
(21, 2, 21, 2018, 'Серебристый', 'sedan', 'manual', 1.4, 'petrol', 'front', 6.8, 'cash', 'basic', 'Д888ДД777', 72000, 1800.00, 150.00, 3000.00, 'available', 'premium', 'Надёжный компактный седан, отличный вариант для города.', 0, '2026-04-30 07:19:22', '2026-04-30 07:20:58'),
(22, 2, 22, 2021, 'Чёрный', 'coupe', 'automatic', 3.6, 'petrol', 'rear', 11.0, 'card', 'full', 'З999ЗЗ777', 10000, 11000.00, 900.00, 22000.00, 'available', 'premium', 'Агрессивный спорткар с мощным V6 и узнаваемым дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:27:54'),
(23, 2, 23, 2020, 'Оранжевый', 'coupe', 'automatic', 3.6, 'petrol', 'rear', 12.0, 'card', 'basic', 'И000ИИ777', 18000, 10500.00, 850.00, 21000.00, 'available', 'premium', 'Массивный мускул-кар в ретро-стиле с мощным двигателем.', 0, '2026-04-30 07:19:22', '2026-04-30 07:27:59'),
(24, 2, 24, 2019, 'Чёрный', 'sedan', 'automatic', 3.6, 'petrol', 'rear', 10.5, 'cash,card', 'full', 'К111КК777', 45000, 9500.00, 700.00, 18000.00, 'available', 'premium', 'Спортивный седан с брутальным характером и просторным салоном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:28:03'),
(25, 2, 25, 2017, 'Белый', 'sedan', 'automatic', 2.0, 'petrol', 'rear', 8.5, 'transfer', 'basic', 'Л222ЛЛ777', 68000, 4500.00, 350.00, 9000.00, 'available', 'premium', 'Премиальный седан с отличной динамикой и стильным дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:21:12'),
(106, 2, 26, 2019, 'Тёмно-серый', 'sedan', 'automatic', 3.6, 'petrol', 'rear', 10.0, 'card', 'full', 'М333ММ777', 32000, 6500.00, 500.00, 13000.00, 'available', 'premium', 'Роскошный представительский седан с V6 и ярким дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(107, 2, 27, 2019, 'Серебристый', 'hatchback', 'manual', 1.4, 'petrol', 'front', 5.8, 'cash', 'basic', 'Н444НН777', 48000, 1900.00, 150.00, 3500.00, 'available', 'premium', 'Европейский хэтчбек с экономичным мотором и точным рулевым управлением.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(108, 2, 28, 2020, 'Синий', 'sedan', 'automatic', 2.0, 'diesel', 'front', 5.0, 'card,transfer', 'full', 'П555ПП777', 26000, 3500.00, 280.00, 7000.00, 'available', 'premium', 'Просторный и комфортный дизельный седан для дальних поездок.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(109, 2, 29, 2021, 'Красный', 'hatchback', 'automatic', 1.4, 'petrol', 'front', 5.5, 'cash,card', 'basic', 'Р666РР777', 15000, 2800.00, 220.00, 5000.00, 'available', 'premium', 'Современный Golf с качественным салоном и отличной управляемостью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(110, 2, 30, 2020, 'Тёмно-синий', 'sedan', 'automatic', 2.0, 'petrol', 'front', 6.5, 'transfer', 'full', 'С777СС777', 32000, 3800.00, 300.00, 8000.00, 'available', 'premium', 'Классический бизнес-седан с просторным салоном и багажником.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(111, 2, 31, 2019, 'Белый', 'sedan', 'automatic', 2.0, 'petrol', 'front', 7.0, 'card', 'basic', 'Т888ТТ777', 47000, 2700.00, 200.00, 5500.00, 'available', 'premium', 'Стильный корейский седан с хорошим оснащением и надёжностью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(112, 2, 32, 2021, 'Чёрный', '', 'automatic', 3.3, 'petrol', 'all', 9.0, 'cash,card', 'full', 'У999УУ777', 9000, 8500.00, 650.00, 16000.00, 'available', 'premium', 'Заряженный лифтбек с турбированным V6 и полным приводом.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(113, 2, 33, 2020, 'Серебристый', 'sedan', 'automatic', 2.0, 'hybrid', 'front', 4.8, 'transfer', 'full', 'Ф000ФФ777', 22000, 3200.00, 250.00, 6000.00, 'available', 'premium', 'Экономичный гибридный седан с современным дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(114, 2, 34, 2021, 'Синий', 'sedan', 'manual', 1.6, 'petrol', 'front', 6.2, 'cash', 'basic', 'Ф111ФФ777', 18000, 2100.00, 160.00, 4000.00, 'available', 'premium', 'Компактный и экономичный седан, идеален для начинающих.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(115, 2, 35, 2019, 'Зелёный', 'coupe', 'automatic', 4.0, 'petrol', 'rear', 10.5, 'card', 'full', 'А444АА777', 12000, 30000.00, 2500.00, 50000.00, 'available', 'premium', 'Британский спорткар с элегантным дизайном и мощным V8.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(116, 2, 36, 2020, 'Серебристый', 'coupe', 'automatic', 5.2, 'petrol', 'rear', 12.0, 'card,transfer', 'full', 'Б555ББ777', 8000, 40000.00, 3000.00, 70000.00, 'available', 'premium', 'Роскошное британское GT с V12 и изысканным интерьером.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(117, 2, 37, 2021, 'Тёмно-синий', 'coupe', 'automatic', 6.0, 'petrol', 'all', 14.0, 'card', 'full', 'В666ВВ777', 5000, 45000.00, 3500.00, 80000.00, 'available', 'premium', 'Люксовое купе с невероятной мощностью и комфортом.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(118, 2, 38, 2020, 'Чёрный', 'sedan', 'automatic', 6.0, 'petrol', 'all', 13.5, 'card', 'full', 'Г777ГГ777', 6000, 48000.00, 3800.00, 85000.00, 'available', 'premium', 'Премиальный седан, сочетающий роскошь и динамику.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(119, 2, 39, 2019, 'Синий', 'coupe', 'automatic', 8.0, 'petrol', 'all', 20.0, 'transfer', 'full', 'Д999ДД777', 3000, 150000.00, 12000.00, 200000.00, 'available', 'premium', 'Гиперкар, способный развивать скорость свыше 400 км/ч.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(120, 2, 41, 2018, 'Красный', 'coupe', 'automatic', 3.9, 'petrol', 'rear', 11.5, 'card', 'full', 'Е999ЕЕ777', 25000, 50000.00, 4000.00, 90000.00, 'available', 'premium', 'Итальянский суперкар с турбированным V8 и непревзойдённой управляемостью.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(121, 2, 42, 2019, 'Серебристый', 'convertible', 'automatic', 3.9, 'petrol', 'rear', 10.8, 'card', 'full', 'Ж000ЖЖ777', 18000, 42000.00, 3300.00, 75000.00, 'available', 'premium', 'Роскошный кабриолет с мощным мотором и элегантным стилем.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(122, 2, 43, 2020, 'Зелёный', 'coupe', 'automatic', 5.2, 'petrol', 'all', 13.0, 'card', 'full', 'З111ЗЗ777', 10000, 60000.00, 4800.00, 100000.00, 'available', 'premium', 'Агрессивный суперкар с V10 и футуристическим дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(123, 2, 44, 2019, 'Оранжевый', 'coupe', 'automatic', 6.5, 'petrol', 'all', 16.0, 'card', 'full', 'И222ИИ777', 8000, 75000.00, 6000.00, 120000.00, 'available', 'premium', 'Легендарный V12 гиперкар с космическим дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(124, 2, 45, 2021, 'Чёрный', 'suv', 'automatic', 3.0, 'diesel', 'all', 8.0, 'card,transfer', 'full', 'К333КК777', 15000, 12000.00, 1000.00, 25000.00, 'available', 'premium', 'Роскошный внедорожник с отличной проходимостью и комфортом.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(125, 2, 46, 2019, 'Синий', 'sedan', 'automatic', 3.0, 'diesel', 'rear', 6.5, 'card', 'full', 'Л444ЛЛ777', 45000, 8000.00, 650.00, 15000.00, 'available', 'premium', 'Итальянский спортивный седан с харизматичным дизайном.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(126, 2, 47, 2020, 'Красный', 'sedan', 'automatic', 3.8, 'petrol', 'rear', 10.0, 'card', 'full', 'М555ММ777', 22000, 11000.00, 900.00, 22000.00, 'available', 'premium', 'Представительский седан с итальянским шармом и мощным V8.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(127, 2, 48, 2020, 'Белый', 'hatchback', 'manual', 1.3, 'petrol', 'front', 5.5, 'cash', 'basic', 'Н666НН777', 28000, 1800.00, 140.00, 3500.00, 'available', 'premium', 'Французский хэтчбек с оригинальным дизайном и экономичным мотором.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(128, 2, 49, 2021, 'Серый', 'sedan', 'automatic', 1.6, 'diesel', 'front', 4.2, 'card', 'basic', 'О777ОО777', 19000, 3000.00, 230.00, 6000.00, 'available', 'premium', 'Просторный дизельный седан с высоким уровнем комфорта.', 0, '2026-04-30 07:19:22', '2026-04-30 07:19:22'),
(129, 2, 50, 2020, 'Чёрный', 'sedan', 'automatic', 6.6, 'petrol', 'rear', 14.0, 'transfer', 'full', 'П888ПП777', 6000, 50000.00, 4000.00, 100000.00, 'available', 'premium', 'Абсолютная роскошь и тишина в сочетании с мощным V12.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51'),
(130, 2, 51, 2019, 'Двухцветный', 'coupe', 'automatic', 6.6, 'petrol', 'rear', 13.5, 'transfer', 'full', 'Р999РР777', 8000, 52000.00, 4200.00, 105000.00, 'available', 'premium', 'Роскошное гранд-туре с динамичным характером и непревзойдённым комфортом.', 0, '2026-04-30 07:19:22', '2026-04-30 07:40:51');

-- --------------------------------------------------------

--
-- Структура таблицы `car_brands`
--

CREATE TABLE `car_brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_brands`
--

INSERT INTO `car_brands` (`id`, `name`, `logo`, `description`) VALUES
(1, 'Toyota', NULL, 'Японский автопроизводитель'),
(2, 'BMW', NULL, 'Немецкий премиум-бренд'),
(3, 'Mercedes-Benz', NULL, 'Немецкая роскошь'),
(4, 'Audi', NULL, 'Технологичность и комфорт'),
(5, 'Lada', NULL, 'Отечественный автопром'),
(6, 'Nissan', NULL, 'Японский автопроизводитель'),
(7, 'Porshe', NULL, 'Немецкая роскошь'),
(8, 'Tesla', NULL, 'Американская мечта'),
(9, 'Honda', NULL, 'Японский автопроизводитель, известный надёжностью и инновациями'),
(10, 'Mitsubishi', NULL, 'Японский бренд с богатой историей в автоспорте и внедорожниках'),
(11, 'Subaru', NULL, 'Японский производитель, славящийся оппозитными двигателями и полным приводом'),
(12, 'Lexus', NULL, 'Премиальный подразделение Toyota, символ роскоши и качества'),
(13, 'Ford', NULL, 'Американский автогигант, производящий легендарные модели'),
(14, 'Chevrolet', NULL, 'Американский бренд с широкой линейкой автомобилей'),
(15, 'Dodge', NULL, 'Американский производитель мощных и агрессивных автомобилей'),
(16, 'Cadillac', NULL, 'Премиальный американский бренд, олицетворяющий роскошь'),
(17, 'Opel', NULL, 'Немецкий производитель, популярный в Европе'),
(18, 'Volkswagen', NULL, 'Немецкий автоконцерн, лидер европейского рынка'),
(19, 'Kia', NULL, 'Южнокорейский бренд с современным дизайном и технологиями'),
(20, 'Hyundai', NULL, 'Южнокорейский автопроизводитель, стремительно развивающийся'),
(21, 'Aston Martin', NULL, 'Британский производитель роскошных спортивных автомобилей'),
(22, 'Bentley', NULL, 'Британский бренд ультра-премиальных авто'),
(23, 'Bugatti', NULL, 'Французский производитель гиперкаров, рекордсменов скорости'),
(24, 'Ferrari', NULL, 'Итальянский бренд легендарных спорткаров'),
(25, 'Lamborghini', NULL, 'Итальянский производитель экстремальных суперкаров'),
(26, 'Land Rover', NULL, 'Британский производитель премиальных внедорожников (легендарные модели)'),
(27, 'Maserati', NULL, 'Итальянский бренд элегантных и мощных автомобилей'),
(28, 'Renault', NULL, 'Французский автопроизводитель с богатой историей'),
(29, 'Rolls-Royce', NULL, 'Британский символ абсолютной роскоши');

-- --------------------------------------------------------

--
-- Структура таблицы `car_features`
--

CREATE TABLE `car_features` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_features`
--

INSERT INTO `car_features` (`id`, `name`, `icon`) VALUES
(1, 'Кондиционер', 'fas fa-wind'),
(2, 'Подогрев сидений', 'fas fa-thermometer-half'),
(3, 'Люк', 'fas fa-car-side'),
(4, 'ABS', 'fas fa-car-crash'),
(5, 'Круиз-контроль', 'fas fa-tachometer-alt'),
(6, 'Спортивный режим', 'fas fa-flag-checkered'),
(7, 'Детское кресло', 'fas fa-child'),
(8, 'Навигатор', 'fas fa-map-marked-alt'),
(9, 'Wi-Fi', 'fas fa-wifi'),
(10, 'Видеорегистратор', 'fas fa-video'),
(11, 'Шины на шипах', 'fas fa-snowflake'),
(12, 'Багажник на крышу', 'fas fa-box-open');

-- --------------------------------------------------------

--
-- Структура таблицы `car_feature_assignments`
--

CREATE TABLE `car_feature_assignments` (
  `car_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_feature_assignments`
--

INSERT INTO `car_feature_assignments` (`car_id`, `feature_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(3, 1),
(3, 2),
(3, 4),
(3, 5),
(4, 1),
(4, 2),
(4, 4),
(4, 5),
(5, 1),
(5, 2),
(5, 4),
(5, 5),
(6, 1),
(6, 2),
(6, 4),
(6, 5),
(7, 1),
(7, 2),
(7, 4),
(7, 5),
(8, 1),
(8, 2),
(8, 4),
(8, 5),
(9, 1),
(9, 2),
(9, 4),
(9, 5),
(10, 1),
(10, 2),
(10, 4),
(10, 5),
(11, 1),
(11, 2),
(11, 4),
(11, 5),
(12, 1),
(12, 2),
(12, 4),
(12, 5),
(13, 1),
(13, 2),
(13, 4),
(13, 5),
(14, 1),
(14, 2),
(14, 4),
(14, 5),
(15, 1),
(15, 2),
(15, 4),
(15, 5),
(16, 1),
(16, 2),
(16, 4),
(16, 5),
(17, 1),
(17, 2),
(17, 4),
(17, 5),
(18, 1),
(18, 2),
(18, 4),
(18, 5),
(19, 1),
(19, 2),
(19, 4),
(19, 5),
(20, 1),
(20, 2),
(20, 4),
(20, 5),
(21, 1),
(21, 2),
(21, 4),
(21, 5),
(22, 1),
(22, 2),
(22, 4),
(22, 5),
(23, 1),
(23, 2),
(23, 4),
(23, 5),
(24, 1),
(24, 2),
(24, 4),
(24, 5),
(25, 1),
(25, 2),
(25, 4),
(25, 5),
(106, 1),
(106, 2),
(106, 4),
(106, 5),
(107, 1),
(107, 2),
(107, 4),
(107, 5),
(108, 1),
(108, 2),
(108, 4),
(108, 5),
(109, 1),
(109, 2),
(109, 4),
(109, 5),
(110, 1),
(110, 2),
(110, 4),
(110, 5),
(111, 1),
(111, 2),
(111, 4),
(111, 5),
(112, 1),
(112, 2),
(112, 4),
(112, 5),
(113, 1),
(113, 2),
(113, 4),
(113, 5),
(114, 1),
(114, 2),
(114, 4),
(114, 5),
(115, 1),
(115, 2),
(115, 4),
(115, 5),
(116, 1),
(116, 2),
(116, 4),
(116, 5),
(117, 1),
(117, 2),
(117, 4),
(117, 5),
(118, 1),
(118, 2),
(118, 4),
(118, 5),
(119, 1),
(119, 2),
(119, 4),
(119, 5),
(120, 1),
(120, 2),
(120, 4),
(120, 5),
(121, 1),
(121, 2),
(121, 4),
(121, 5),
(122, 1),
(122, 2),
(122, 4),
(122, 5),
(123, 1),
(123, 2),
(123, 4),
(123, 5),
(124, 1),
(124, 2),
(124, 4),
(124, 5),
(125, 1),
(125, 2),
(125, 4),
(125, 5),
(126, 1),
(126, 2),
(126, 4),
(126, 5),
(127, 1),
(127, 2),
(127, 4),
(127, 5),
(128, 1),
(128, 2),
(128, 4),
(128, 5),
(129, 1),
(129, 2),
(129, 4),
(129, 5),
(130, 1),
(130, 2),
(130, 4),
(130, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `car_images`
--

CREATE TABLE `car_images` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_images`
--

INSERT INTO `car_images` (`id`, `car_id`, `image_path`, `is_main`, `sort_order`) VALUES
(1, 1, '/uploads/cars/tayota-camry.jpg', 1, 1),
(2, 2, '/uploads/cars/nissan-gt.png', 1, 1),
(3, 3, '/uploads/cars/porshe-911.png', 1, 1),
(4, 4, '/uploads/cars/bmw-m4.jpg', 1, 1),
(5, 5, '/uploads/cars/mercedes-e.png', 1, 1),
(6, 6, '/uploads/cars/tesla-X.png', 1, 1),
(7, 7, '/uploads/cars/audi-a6.jpg', 1, 1),
(8, 8, '/uploads/cars/audi-r8.jpg', 1, 1),
(9, 9, '/uploads/cars/lada-vesta.jpg', 1, 1),
(10, 10, '/uploads/cars/lada-granta.jpg', 1, 1),
(11, 11, '/uploads/cars/honda-civic.jpg', 1, 1),
(12, 12, '/uploads/cars/honda-accord.jpg', 1, 1),
(13, 13, '/uploads/cars/mitsubishi-lancer.webp', 1, 1),
(14, 14, '/uploads/cars/mitsubishi-eclipse.png', 1, 1),
(15, 15, '/uploads/cars/subaru-impreza.jpg', 1, 1),
(16, 16, '/uploads/cars/subaru-legacy.png', 1, 1),
(17, 17, '/uploads/cars/lexus-ES.jpg', 1, 1),
(18, 18, '/uploads/cars/lexus-IS.png', 1, 1),
(19, 19, '/uploads/cars/ford-mustang.png', 1, 1),
(20, 20, '/uploads/cars/ford-focus.png', 1, 1),
(21, 21, '/uploads/cars/chevrolet-cruze.png', 1, 1),
(22, 22, '/uploads/cars/chevrolet-camaro.png', 1, 1),
(23, 23, '/uploads/cars/dodge-challenger.jpg', 1, 1),
(24, 24, '/uploads/cars/dodge-charger.jpg', 1, 1),
(25, 25, '/uploads/cars/cadillac-ATS.png', 1, 1),
(26, 106, '/uploads/cars/cadillac-CTS.png', 1, 1),
(27, 107, '/uploads/cars/opel-astra.jpg', 1, 1),
(28, 108, '/uploads/cars/opel-insignia.jpg', 1, 1),
(29, 109, '/uploads/cars/volkswagen-golf.png', 1, 1),
(30, 110, '/uploads/cars/volkswagen-passat.jpg', 1, 1),
(31, 111, '/uploads/cars/kia-optima.webp', 1, 1),
(32, 112, '/uploads/cars/kia-stinger.webp', 1, 1),
(33, 113, '/uploads/cars/hyundai-sonata.webp', 1, 1),
(34, 114, '/uploads/cars/hyundai-elantra.png', 1, 1),
(35, 115, '/uploads/cars/aston-martin-virage.jpg', 1, 1),
(36, 116, '/uploads/cars/aston-martin-DB11.webp', 1, 1),
(37, 117, '/uploads/cars/bentley-continental-GT.avif', 1, 1),
(38, 118, '/uploads/cars/bentley-flying-spur.webp', 1, 1),
(39, 119, '/uploads/cars/bugatti-chiron.jpg', 1, 1),
(40, 120, '/uploads/cars/ferrari-488GTB.png', 1, 1),
(41, 121, '/uploads/cars/ferrari-portofino.png', 1, 1),
(42, 122, '/uploads/cars/lamborghini-huracan.png', 1, 1),
(43, 123, '/uploads/cars/lamborghini-aventador.jpg', 1, 1),
(44, 124, '/uploads/cars/land-rover-range-rover.png', 1, 1),
(45, 125, '/uploads/cars/maserati-ghibli.jpg', 1, 1),
(46, 126, '/uploads/cars/maserati-quattroporte.png', 1, 1),
(47, 127, '/uploads/cars/renault-megane.png', 1, 1),
(48, 128, '/uploads/cars/renault-talisman.webp', 1, 1),
(49, 129, '/uploads/cars/rolls-royce-ghost.png', 1, 1),
(50, 130, '/uploads/cars/rolls-royce-wraith.webp', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `car_models`
--

CREATE TABLE `car_models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `year_start` int(4) DEFAULT NULL,
  `year_end` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_models`
--

INSERT INTO `car_models` (`id`, `brand_id`, `name`, `year_start`, `year_end`) VALUES
(1, 1, 'Camry', 2018, NULL),
(2, 6, 'Gt-R', 2015, NULL),
(3, 7, '911', 2019, NULL),
(4, 2, 'M4 Competition', 2020, NULL),
(5, 3, 'E-Class', 2017, NULL),
(6, 8, 'Model-X', 2018, NULL),
(7, 4, 'A6', 2016, NULL),
(8, 4, 'R8', 2019, NULL),
(9, 5, 'Vesta', 2020, NULL),ё
(10, 5, 'Granta', 2019, NULL),
(11, 9, 'Civic', 2016, NULL),
(12, 9, 'Accord', 2018, NULL),
(13, 10, 'Lancer', 2015, 2019),
(14, 10, 'Eclipse ', 2018, NULL),
(15, 11, 'Impreza', 2017, NULL),
(16, 11, 'Legacy', 2016, NULL),
(17, 12, 'ES', 2019, NULL),
(18, 12, 'IS', 2017, NULL),
(19, 13, 'Mustang', 2015, NULL),
(20, 13, 'Focus', 2018, NULL),
(21, 14, 'Cruze', 2016, 2019),
(22, 14, 'Camaro', 2016, NULL),
(23, 15, 'Challenger', 2015, NULL),
(24, 15, 'Charger', 2017, NULL),
(25, 16, 'ATS', 2015, 2019),
(26, 16, 'CTS', 2016, NULL),
(27, 17, 'Astra', 2016, 2021),
(28, 17, 'Insignia', 2017, 2022),
(29, 18, 'Golf', 2017, NULL),
(30, 18, 'Passat', 2018, NULL),
(31, 19, 'Optima', 2016, 2020),
(32, 19, 'Stinger', 2018, NULL),
(33, 20, 'Sonata', 2017, NULL),
(34, 20, 'Elantra', 2016, NULL),
(35, 21, 'Vantage', 2018, NULL),
(36, 21, 'DB11', 2016, NULL),
(37, 22, 'Continental GT', 2017, NULL),
(38, 22, 'Flying Spur', 2018, NULL),
(39, 23, 'Chiron', 2016, NULL),
(40, 23, 'Veyron', 2010, 2015),
(41, 24, '488 GTB', 2015, 2019),
(42, 24, 'Portofino', 2017, NULL),
(43, 25, 'Huracán', 2014, NULL),
(44, 25, 'Aventador', 2011, 2022),
(45, 26, 'Range Rover Sport', 2017, NULL),
(46, 27, 'Ghibli', 2014, NULL),
(47, 27, 'Quattroporte', 2017, NULL),
(48, 28, 'Megane', 2016, NULL),
(49, 28, 'Talisman', 2017, NULL),
(50, 29, 'Ghost', 2015, NULL),
(51, 29, 'Wraith', 2016, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'Артём', 'artem@mail.ru', '+79125226420', 'Все отлично', '2026-03-14 12:49:20');

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `favorites`
--

INSERT INTO `favorites` (`user_id`, `car_id`) VALUES
(3, 1),
(3, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1773386541),
('m260313_072050_create_users_table', 1773386544),
('m260313_072308_create_car_brands_table', 1773386625),
('m260313_072405_create_car_models_table', 1773386691),
('m260313_072516_create_cars_table', 1773386798),
('m260313_072706_create_car_features_table', 1773386866),
('m260313_072805_create_car_images_table', 1773386917),
('m260313_072852_create_car_feature_assignments_table', 1773386970),
('m260313_072957_create_bookings_table', 1773387033),
('m260313_073050_create_payments_table', 1773387084),
('m260313_073147_create_reviews_table', 1773387142),
('m260313_073243_create_favorites_table', 1773387195);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 5, 'Автомобиль просто огонь! Брал на выходные, чтобы прокатиться за город. Машина в идеальном состоянии, салон чистый, двигатель звучит божественно. Отдельное спасибо за быструю подачу и приятный бонус - полный бак. Обязательно возьму ещё!', '2026-03-14 14:41:40');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `patronymic` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('user','owner','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `patronymic`, `email`, `password`, `auth_key`, `phone`, `avatar`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Иван', 'Иванов', 'Иванович', 'admin@mail.ru', '$2y$13$zAPzRfOFfJfwG5wC2VfB1.9vLAxNBhyp3jpfRHWnaydBXvba.bqZi', '3r0GbGYLZ1q7xR0RJ54x9YNrMwzx4Kp8', '+7 (800) 555-35-35', NULL, 'admin', '2026-03-13 12:19:57', '2026-03-13 12:46:08'),
(2, 'Artem', 'Артём', 'Воинков', 'Александрович', 'artem@mail.ru', '$2y$13$l2jZ2CVedg/RXxD9pNm0HeYQCGr/nVDNiErVR4828w70EYThgj8TS', 'xZORMCc2SLDals91_YiF6xNhRUgvoyiM', '+7 (912) 522-64-20', '/uploads/avatars/2_1773485175.jpg', 'owner', '2026-03-13 12:47:23', '2026-03-14 10:46:15'),
(3, 'Atmoteam', 'Иван', 'Макаров', 'Викторович', 'Neu3BecTHo@mail.ru', '$2y$13$E.TEGR3HCXvtXb7kC14z6OsRFFXnTI/ArJsa1zRDZ8baehOt5wIfO', 'qeoWrS4P1I6T8xowvzRk67SWZXTGUZ91', '+7 (922) 560-97-65', '/uploads/avatars/3_1773479644.jpg', 'user', '2026-03-13 12:50:29', '2026-03-14 09:14:04');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-bookings-car_id` (`car_id`),
  ADD KEY `fk-bookings-user_id` (`user_id`);

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`),
  ADD KEY `fk-cars-owner_id` (`owner_id`),
  ADD KEY `fk-cars-model_id` (`model_id`);

--
-- Индексы таблицы `car_brands`
--
ALTER TABLE `car_brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `car_features`
--
ALTER TABLE `car_features`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `car_feature_assignments`
--
ALTER TABLE `car_feature_assignments`
  ADD PRIMARY KEY (`car_id`,`feature_id`),
  ADD KEY `fk-car_feature_assignments-feature_id` (`feature_id`);

--
-- Индексы таблицы `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-car_images-car_id` (`car_id`);

--
-- Индексы таблицы `car_models`
--
ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-car_models-brand_id` (`brand_id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`car_id`),
  ADD KEY `fk-favorites-car_id` (`car_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-payments-booking_id` (`booking_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT для таблицы `car_brands`
--
ALTER TABLE `car_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `car_features`
--
ALTER TABLE `car_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `car_models`
--
ALTER TABLE `car_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk-bookings-car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-bookings-user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk-cars-model_id` FOREIGN KEY (`model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-cars-owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `car_feature_assignments`
--
ALTER TABLE `car_feature_assignments`
  ADD CONSTRAINT `fk-car_feature_assignments-car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-car_feature_assignments-feature_id` FOREIGN KEY (`feature_id`) REFERENCES `car_features` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `fk-car_images-car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `car_models`
--
ALTER TABLE `car_models`
  ADD CONSTRAINT `fk-car_models-brand_id` FOREIGN KEY (`brand_id`) REFERENCES `car_brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk-favorites-car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-favorites-user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk-payments-booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk-reviews-booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
