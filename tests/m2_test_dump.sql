-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: saas-m2-mysql
-- Час створення: Лис 18 2019 р., 14:07
-- Версія сервера: 5.7.27
-- Версія PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `m2`
--

-- --------------------------------------------------------

--
-- Структура таблиці `device`
--

CREATE TABLE `device` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `parent_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `device`
--

INSERT INTO `device` (`id`, `name`, `created_at`, `updated_at`, `parent_id`, `division_id`, `description`, `level`) VALUES
('63bea125-46f1-4d59-b6ec-65000d13ac1f', 'Sprinkler', 1573833585, 1573833585, NULL, '37032816-e587-44cd-9a46-50819f2996b9', 'test description', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `division`
--

CREATE TABLE `division` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `division`
--

INSERT INTO `division` (`id`, `name`, `alias`, `description`) VALUES
('37032816-e587-44cd-9a46-50819f2996b9', 'Alarm', 'alarm', NULL),
('6a38e866-e068-42f8-b21f-e5000389b6fd', 'Backflow', 'backflow', NULL),
('95f79e37-b4f3-4402-a946-64a33fe509b3', 'Fire', 'fire', NULL),
('d2be305f-dba6-42e9-a786-cea951e3446d', 'Plumbing', 'plumbing', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `facility`
--

CREATE TABLE `facility` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `first_name`, `last_name`) VALUES
(1, 'manager@test.com', 'manager@test.com', 'manager@test.com', 'manager@test.com', 1, NULL, '$2y$15$iRp/cTO9prP9cGcH9bY/uuW6csM/XzJKzsZJyTkRvX621ciX2y8Sy', '2019-11-18 14:06:11', NULL, NULL, 'a:2:{i:0;s:5:\"ADMIN\";i:1;s:7:\"MANAGER\";}', NULL, NULL),
(5, 'admin@test.com', 'admin@test.com', 'admin@test.com', 'admin@test.com', 1, NULL, '$2y$15$KfyYB5ITqq4gRvBHiGMSLegG2gBOl5nKpT8UF7cfMLGBKpdRbhCZO', NULL, NULL, NULL, 'a:2:{i:0;s:5:\"ADMIN\";i:1;s:7:\"MANAGER\";}', NULL, NULL),
(7, 'admin2@test.com', 'admin2@test.com', 'admin2@test.com', 'admin2@test.com', 1, NULL, '$2y$15$kPAjExiJ5DdaNZ1cbx95C.hz5otW9Jfmxm1CCg.zr96TEKB/v..Sq', NULL, NULL, NULL, 'a:2:{i:0;s:10:\"ADMIN_RULE\";i:1;s:12:\"MANAGER_ROLE\";}', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `item`
--

CREATE TABLE `item` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paragraph_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `remembered` tinyint(1) NOT NULL,
  `printable` tinyint(1) NOT NULL,
  `item_type_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_answer_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `require` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `item_category`
--

CREATE TABLE `item_category` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `item_type`
--

CREATE TABLE `item_type` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_category_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('0001_Create_Fos_User_Table', '2019-10-21 08:56:34'),
('0002_Create_Device_Table', '2019-11-15 15:41:31'),
('0003_Create_Report_Template_Table', '2019-11-15 15:41:32'),
('0004_Create_Report_Template_Version_Table', '2019-11-15 15:41:32'),
('0005_Create_Report_Template_Version_Status_Table', '2019-11-15 15:41:32'),
('0006_Create_Service_Table', '2019-11-15 15:41:32'),
('0007_Create_Section_Table', '2019-11-15 15:41:32'),
('0008_Create_Facility_Table', '2019-11-15 15:41:32'),
('0008_Create_Paragraph_Table', '2019-11-15 15:41:32'),
('0009_Create_Item_Table', '2019-11-15 15:41:32'),
('0010_Create_Item_Type_Table', '2019-11-15 15:41:32'),
('0011_Create_Item_Category_Table', '2019-11-15 15:41:32'),
('0012_Insert_Statuses_For_RTVS', '2019-11-15 15:41:32'),
('0013_Service_Device_Reference_Into_ReportTemplate_Entity', '2019-11-15 15:41:33'),
('0014_Add_Relations_In_ReportTemplateVersion_Entity', '2019-11-15 15:41:34'),
('0015_Add_Device_Facility_Relations_Into_Service_Entity', '2019-11-15 15:41:34'),
('0016_Add_FirstName_And_LastName_In_FosUser_Table', '2019-11-15 15:41:35'),
('0017_Add_Relations_For_ReportTemplateVersionStatus_Entity', '2019-11-15 15:41:35'),
('0018_Create_Division_Table', '2019-11-15 15:41:35'),
('0019_Change_Device_Table_With_Relations', '2019-11-15 15:41:35'),
('0020_Fill_Division_Table', '2019-11-15 15:41:36'),
('0021_Create_ParagraphFilter_Table', '2019-11-15 15:41:36'),
('0022_Create_StyleTemplate_Table', '2019-11-15 15:41:36'),
('0023_Change_Paragraph_Table', '2019-11-15 15:41:37');

-- --------------------------------------------------------

--
-- Структура таблиці `paragraph`
--

CREATE TABLE `paragraph` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `parent_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style_template_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `printable` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `paragraph_filter_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_by_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `paragraph`
--

INSERT INTO `paragraph` (`id`, `section_id`, `title`, `position`, `parent_id`, `device_id`, `style_template_id`, `printable`, `created_at`, `updated_at`, `paragraph_filter_id`, `level`, `created_by_id`, `modified_by_id`) VALUES
('63bea125-46f1-4d59-b6ec-13000d13ac9f', '6647e03a-4f98-4a25-acc7-0ebad8fba229', 'Paragraph Title', 1, NULL, NULL, NULL, 1, 1574085977, 1574085977, NULL, 1, 1, 1),
('ac0cec75-b17d-4509-b15a-29621c41b17d', '7501dca9-9a92-487a-8cf7-5dd872fd8064', 'Paragraph Title', 1, NULL, '63bea125-46f1-4d59-b6ec-65000d13ac1f', NULL, 1, 1574085977, 1574085977, 'inspection', 1, 1, 1),
('ac0cec75-b17d-4509-b15a-29621c41b16d', '7501dca9-9a92-487a-8cf7-5dd872fd8064', 'Paragraph Title', 2, 'ac0cec75-b17d-4509-b15a-29621c41b17d', '63bea125-46f1-4d59-b6ec-65000d13ac1f', NULL, 1, 1574085977, 1574085977, 'inspection', 2, 1, 1),
('ac0cec75-b17d-4509-b15a-29621c41b15d', '7501dca9-9a92-487a-8cf7-5dd872fd8064', 'Paragraph Title', 3, 'ac0cec75-b17d-4509-b15a-29621c41b16d', '63bea125-46f1-4d59-b6ec-65000d13ac1f', NULL, 1, 1574085977, 1574085977, 'inspection', 3, 1, 1);
-- --------------------------------------------------------

--
-- Структура таблиці `paragraph_filter`
--

CREATE TABLE `paragraph_filter` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paragraph_filter` (`id`, `name`, `description`) VALUES
('on_site', 'By Facility', ''),
('inspection', 'By Inspection', ''),
('by_ancestor', 'By Parent', ''),
('same_as_parent', 'Same As Parent', '');

-- --------------------------------------------------------

--
-- Структура таблиці `report_template`
--

CREATE TABLE `report_template` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `service_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `report_template`
--

INSERT INTO `report_template` (`id`, `name`, `description`, `created_at`, `service_id`, `device_id`) VALUES
('63bea125-46f1-4d59-b6ec-65000d13ac34', 'Test', 'Fire Alarm System desciption', 1573837077, '63bea125-46f1-4d59-b6ec-65000d13acc1', '63bea125-46f1-4d59-b6ec-65000d13ac1f'),
('ac0cec75-b17d-4509-b15a-29621c41b188', 'Test', 'Fire Alarm System desciption', 1573837077, '63bea125-46f1-4d59-b6ec-65000d13acc1', '63bea125-46f1-4d59-b6ec-65000d13ac1f');

-- --------------------------------------------------------

--
-- Структура таблиці `report_template_version`
--

CREATE TABLE `report_template_version` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version_number` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `report_template_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `report_template_version_status_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `report_template_version`
--

INSERT INTO `report_template_version` (`id`, `version_number`, `created_at`, `updated_at`, `report_template_id`, `created_by_id`, `modified_by_id`, `report_template_version_status_id`) VALUES
('6647e03a-4f98-4a25-acc7-0ebad8fba230', 1, 1573837077, 1573837077, '63bea125-46f1-4d59-b6ec-65000d13ac34', 1, 1, 'draft'),
('b34dad6d-2d6a-47e9-a807-734e6d1590a7', 1, 1573837077, 1573837077, 'ac0cec75-b17d-4509-b15a-29621c41b188', 1, 1, 'draft');

-- --------------------------------------------------------

--
-- Структура таблиці `report_template_version_status`
--

CREATE TABLE `report_template_version_status` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `report_template_version_status`
--

INSERT INTO `report_template_version_status` (`id`, `name`, `description`) VALUES
('archived', 'Archived', ''),
('deleted', 'Deleted', ''),
('draft', 'Draft', ''),
('published', 'Published', '');

-- --------------------------------------------------------

--
-- Структура таблиці `section`
--

CREATE TABLE `section` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_template_version_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `printable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `section`
--

INSERT INTO `section` (`id`, `report_template_version_id`, `created_by_id`, `modified_by_id`, `title`, `position`, `created_at`, `updated_at`, `printable`) VALUES
('7501dca9-9a92-487a-8cf7-5dd872fd8064', 'b34dad6d-2d6a-47e9-a807-734e6d1590a7', 1, 1, 'test', 2, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba229', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, NULL, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba228', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, 1, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba227', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, 2, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba226', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, 3, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba225', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, 4, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba224', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, 5, 1573837077, 1573837077, 1),
('6647e03a-4f98-4a25-acc7-0ebad8fba223', '6647e03a-4f98-4a25-acc7-0ebad8fba230', 5, 5, NULL, 6, 1573837077, 1573837077, 1),
('0f016e65-748f-4d23-9a85-af7d163576b9', '6647e03a-4f98-4a25-acc7-0ebad8fba230', '5', '5', 'Section - 4', null, '1573837077', '1573837077', 1);


-- --------------------------------------------------------

--
-- Структура таблиці `service`
--

CREATE TABLE `service` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `updated_at` int(11) NOT NULL COMMENT '(DC2Type:timestamp)',
  `facility_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `service`
--

INSERT INTO `service` (`id`, `name`, `comment`, `created_at`, `updated_at`, `facility_id`, `device_id`) VALUES
('63bea125-46f1-4d59-b6ec-65000d13acc1', 'Sprinkler Service', 'Test Comment', 1573833636, 1573833636, NULL, '63bea125-46f1-4d59-b6ec-65000d13ac1f');

-- --------------------------------------------------------

--
-- Структура таблиці `style_template`
--

CREATE TABLE `style_template` (
  `id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `style_template` (`id`, `name`, `body`) VALUES
('3a45f743-424c-4839-a395-ead0cd2e70c3', 'Template 1', '');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_92FB68E727ACA70` (`parent_id`),
  ADD KEY `IDX_92FB68E41859289` (`division_id`);

--
-- Індекси таблиці `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`);

--
-- Індекси таблиці `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Індекси таблиці `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`);

--
-- Індекси таблиці `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`);

--
-- Індекси таблиці `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`);

--
-- Індекси таблиці `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Індекси таблиці `paragraph`
--
ALTER TABLE `paragraph`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`),
  ADD KEY `IDX_7DD39862D823E37A` (`section_id`),
  ADD KEY `IDX_7DD39862727ACA70` (`parent_id`),
  ADD KEY `IDX_7DD3986294A4C7D4` (`device_id`),
  ADD KEY `IDX_7DD3986210FE5A77` (`style_template_id`),
  ADD KEY `IDX_7DD398623F7BE73C` (`paragraph_filter_id`),
  ADD KEY `IDX_7DD39862B03A8386` (`created_by_id`),
  ADD KEY `IDX_7DD3986299049ECE` (`modified_by_id`);

--
-- Індекси таблиці `paragraph_filter`
--
ALTER TABLE `paragraph_filter`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `report_template`
--
ALTER TABLE `report_template`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`),
  ADD KEY `IDX_970086FEED5CA9E6` (`service_id`),
  ADD KEY `IDX_970086FE94A4C7D4` (`device_id`);

--
-- Індекси таблиці `report_template_version`
--
ALTER TABLE `report_template_version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`),
  ADD KEY `IDX_A955100EB4C2A4B0` (`report_template_id`),
  ADD KEY `IDX_A955100EB03A8386` (`created_by_id`),
  ADD KEY `IDX_A955100E99049ECE` (`modified_by_id`),
  ADD KEY `IDX_A955100E5B97B87D` (`report_template_version_status_id`);

--
-- Індекси таблиці `report_template_version_status`
--
ALTER TABLE `report_template_version_status`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`),
  ADD KEY `IDX_2D737AEF3D1C5FB9` (`report_template_version_id`),
  ADD KEY `IDX_2D737AEFB03A8386` (`created_by_id`),
  ADD KEY `IDX_2D737AEF99049ECE` (`modified_by_id`);

--
-- Індекси таблиці `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_idx` (`id`),
  ADD KEY `IDX_E19D9AD294A4C7D4` (`device_id`),
  ADD KEY `IDX_E19D9AD2A7014910` (`facility_id`);

--
-- Індекси таблиці `style_template`
--
ALTER TABLE `style_template`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `FK_92FB68E41859289` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`),
  ADD CONSTRAINT `FK_92FB68E727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `device` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `paragraph`
--
ALTER TABLE `paragraph`
  ADD CONSTRAINT `FK_7DD3986210FE5A77` FOREIGN KEY (`style_template_id`) REFERENCES `style_template` (`id`),
  ADD CONSTRAINT `FK_7DD398623F7BE73C` FOREIGN KEY (`paragraph_filter_id`) REFERENCES `paragraph_filter` (`id`),
  ADD CONSTRAINT `FK_7DD39862727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `paragraph` (`id`),
  ADD CONSTRAINT `FK_7DD3986294A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`),
  ADD CONSTRAINT `FK_7DD3986299049ECE` FOREIGN KEY (`modified_by_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_7DD39862B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_7DD39862D823E37A` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `report_template`
--
ALTER TABLE `report_template`
  ADD CONSTRAINT `FK_970086FE94A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`),
  ADD CONSTRAINT `FK_970086FEED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `report_template_version`
--
ALTER TABLE `report_template_version`
  ADD CONSTRAINT `FK_A955100E5B97B87D` FOREIGN KEY (`report_template_version_status_id`) REFERENCES `report_template_version_status` (`id`),
  ADD CONSTRAINT `FK_A955100E99049ECE` FOREIGN KEY (`modified_by_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_A955100EB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_A955100EB4C2A4B0` FOREIGN KEY (`report_template_id`) REFERENCES `report_template` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `FK_2D737AEF3D1C5FB9` FOREIGN KEY (`report_template_version_id`) REFERENCES `report_template_version` (`id`),
  ADD CONSTRAINT `FK_2D737AEF99049ECE` FOREIGN KEY (`modified_by_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_2D737AEFB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `fos_user` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `FK_E19D9AD294A4C7D4` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`),
  ADD CONSTRAINT `FK_E19D9AD2A7014910` FOREIGN KEY (`facility_id`) REFERENCES `facility` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
