--
-- Dumping database for table `career_levels`
--

INSERT INTO `career_levels` (`career_level_id`, `order_by`) VALUES
('ASST-MANAGER', 5),
('DIREKTUR', 8),
('GENERAL-MANAGER', 7),
('MANAGER', 6),
('STAFF', 3),
('SUPERVISOR', 4),
('TRAINEE', 2),
('VOLUNTEER', 1);

--
-- Dumping database for table `industries`
--

INSERT INTO `industries` (`industry_id`, `industry_name`) VALUES
(1, 'Accounts / Audit'),
(2, 'Advertising / Publishing'),
(3, 'Aerospace'),
(4, 'Agribusiness'),
(5, 'Airlines'),
(6, 'Automotive'),
(7, 'Candy / Confectionary'),
(8, 'Chemical'),
(9, 'Computer / IT'),
(10, 'Conglomerate'),
(11, 'Construction'),
(12, 'Consumer Goods'),
(13, 'Cosmetics'),
(14, 'Courier'),
(15, 'Custom Broker / Forwarder'),
(16, 'Education'),
(17, 'Electronics / Semiconductors'),
(18, 'Energy'),
(19, 'Engineering & Construction'),
(20, 'Entertainment'),
(21, 'Environment / Waste Management'),
(22, 'Financials / Banking'),
(23, 'Fishery'),
(24, 'Food & Beverage'),
(25, 'Food Processing'),
(26, 'Forestry / Timber'),
(27, 'Furniture'),
(28, 'Garment / Textile'),
(29, 'Goverment Related'),
(30, 'Health Care'),
(31, 'Hospitality'),
(32, 'Insurance'),
(33, 'Interior Design'),
(34, 'Internet'),
(35, 'Law'),
(36, 'Leather'),
(37, 'Leisure'),
(38, 'Logistics / Transportation'),
(39, 'Machinery / Equipment'),
(40, 'Manufacturing'),
(41, 'Mechanical / Electrical'),
(42, 'Media'),
(43, 'Metal'),
(44, 'Mining / Minerals'),
(45, 'Natural Resources, Others'),
(46, 'Natural Resources Processing'),
(47, 'Non-profit Sector'),
(48, 'Oil and Gas'),
(49, 'Pharmaceuticals'),
(50, 'Polymer / Plastic / Rubber'),
(51, 'Printing and Packaging'),
(52, 'Property / Real Estate'),
(53, 'Pulp / Paper'),
(54, 'Removals'),
(55, 'Restaurant'),
(56, 'Retail'),
(57, 'Security Services'),
(58, 'Service'),
(59, 'Shipping'),
(60, 'Telecommunications'),
(61, 'Toys'),
(62, 'Trading'),
(63, 'Travel & Tour'),
(64, 'Warehousing'),
(65, 'General & Wholesale Trading');

--
-- Dumping database for table `jobs`
--

INSERT INTO `jobs` (`job_id`) VALUES
('FREELANCER'),
('KARYAWAN'),
('MAHASISWA'),
('OWNER'),
('PELAJAR');

--
-- Dumping database for table `regionals`
--

INSERT INTO `regionals` (`id`, `regional_name`, `parent_id`, `province_code`, `city_code`) VALUES
(1, 'ACEH', NULL, '11', '00'),
(2, 'KAB. ACEH SELATAN', 1, '11', '03'),
(3, 'KAB. ACEH TENGGARA', 1, '11', '04'),
(4, 'KAB. ACEH TIMUR', 1, '11', '05'),
(5, 'KAB. ACEH TENGAH', 1, '11', '06'),
(6, 'KAB. ACEH BARAT', 1, '11', '07'),
(7, 'KAB. ACEH BESAR', 1, '11', '08'),
(8, 'KAB. PIDIE', 1, '11', '09'),
(9, 'KAB. ACEH UTARA', 1, '11', '11'),
(10, 'KAB. SIMEULUE', 1, '11', '01'),
(11, 'KAB. ACEH SINGKIL', 1, '11', '02'),
(12, 'KAB. BIREUEN', 1, '11', '10'),
(13, 'KAB. ACEH BARAT DAYA', 1, '11', '12'),
(14, 'KAB. GAYO LUES', 1, '11', '13'),
(15, 'KAB. ACEH JAYA', 1, '11', '16'),
(16, 'KAB. NAGAN RAYA', 1, '11', '15'),
(17, 'KAB. ACEH TAMIANG', 1, '11', '14'),
(18, 'KAB. BENER MERIAH', 1, '11', '17'),
(19, 'KAB. PIDIE JAYA', 1, '11', '18'),
(20, 'KOTA BANDA ACEH', 1, '11', '71'),
(21, 'KOTA SABANG', 1, '11', '72'),
(22, 'KOTA LHOKSEUMAWE', 1, '11', '74'),
(23, 'KOTA LANGSA', 1, '11', '73'),
(24, 'KOTA SUBULUSSALAM', 1, '11', '75'),
(25, 'SUMATERA UTARA', NULL, '12', '00'),
(26, 'KAB. TAPANULI TENGAH', 25, '12', '01'),
(27, 'KAB. TAPANULI UTARA', 25, '12', '05'),
(28, 'KAB. TAPANULI SELATAN', 25, '12', '03'),
(29, 'KAB. NIAS', 25, '12', '01'),
(30, 'KAB. LANGKAT', 25, '12', '13'),
(31, 'KAB. KARO', 25, '12', '11'),
(32, 'KAB. DELI SERDANG', 25, '12', '12'),
(33, 'KAB. SIMALUNGUN', 25, '12', '09'),
(34, 'KAB. ASAHAN', 25, '12', '08'),
(35, 'KAB. LABUHAN BATU', 25, '12', '07'),
(36, 'KAB. DAIRI', 25, '12', '10'),
(37, 'KAB. TOBA SAMOSIR', 25, '12', '06'),
(38, 'KAB. MANDAILING NATAL', 25, '12', '02'),
(39, 'KAB. NIAS SELATAN', 25, '12', '14'),
(40, 'KAB. PAKPAK BHARAT', 25, '12', '16'),
(41, 'KAB. HUMBANG HASUNDUTAN', 25, '12', '15'),
(42, 'KAB. SAMOSIR', 25, '12', '17'),
(43, 'KAB. SERDANG BEDAGAI', 25, '12', '18'),
(44, 'KAB. BATU BARA', 25, '12', '19'),
(45, 'KAB. PADANG LAWAS UTARA', 25, '12', '20'),
(46, 'KAB. PADANG LAWAS', 25, '12', '21'),
(47, 'KOTA MEDAN', 25, '12', '75'),
(48, 'KOTA PEMATANG SIANTAR', 25, '12', '73'),
(49, 'KOTA SIBOLGA', 25, '12', '71'),
(50, 'KOTA TANJUNG BALAI', 25, '12', '72'),
(51, 'KOTA BINJAI', 25, '12', '76'),
(52, 'KOTA TEBING TINGGI', 25, '12', '74'),
(53, 'KOTA PADANGSIDIMPUAN', 25, '12', '77'),
(54, 'SUMATERA BARAT', NULL, '13', '00'),
(55, 'KAB. PESISIR SELATAN', 54, '13', '02'),
(56, 'KAB. SOLOK', 54, '13', '03'),
(57, 'KAB. SIJUNJUNG', 54, '13', '04'),
(58, 'KAB. TANAH DATAR', 54, '13', '05'),
(59, 'KAB. PADANG PARIAMAN', 54, '13', '06'),
(60, 'KAB. AGAM', 54, '13', '07'),
(61, 'KAB. LIMA PULUH KOTA', 54, '13', '08'),
(62, 'KAB. PASAMAN', 54, '13', '09'),
(63, 'KAB. KEPULAUAN MENTAWAI', 54, '13', '01'),
(64, 'KAB. DHARMASRAYA', 54, '13', '11'),
(65, 'KAB. SOLOK SELATAN', 54, '13', '10'),
(66, 'KAB. PASAMAN BARAT', 54, '13', '12'),
(67, 'KOTA PADANG', 54, '13', '71'),
(68, 'KOTA SOLOK', 54, '13', '72'),
(69, 'KOTA SAWAHLUNTO', 54, '13', '73'),
(70, 'KOTA PADANG PANJANG', 54, '13', '74'),
(71, 'KOTA BUKITTINGGI', 54, '13', '75'),
(72, 'KOTA PAYAKUMBUH', 54, '13', '76'),
(73, 'KOTA PARIAMAN', 54, '13', '77'),
(74, 'RIAU', NULL, '14', '00'),
(75, 'KAB. KAMPAR', 74, '14', '06'),
(76, 'KAB. INDRAGIRI HULU', 74, '14', '02'),
(77, 'KAB. BENGKALIS', 74, '14', '08'),
(78, 'KAB. INDRAGIRI HILIR', 74, '14', '03'),
(79, 'KAB. PELALAWAN', 74, '14', '04'),
(80, 'KAB. ROKAN HULU', 74, '14', '07'),
(81, 'KAB. ROKAN HILIR', 74, '14', '09'),
(82, 'KAB. SIAK', 74, '14', '05'),
(83, 'KAB. KUANTAN SINGINGI', 74, '14', '01'),
(84, 'KOTA PEKANBARU', 74, '14', '71'),
(85, 'KOTA DUMAI', 74, '14', '73'),
(86, 'JAMBI', NULL, '15', '00'),
(87, 'KAB. KERINCI', 86, '15', '01'),
(88, 'KAB. MERANGIN', 86, '15', '02'),
(89, 'KAB. SAROLANGUN', 86, '15', '03'),
(90, 'KAB. BATANGHARI', 86, '15', '04'),
(91, 'KAB. MUARO JAMBI', 86, '15', '05'),
(92, 'KAB TANJUNG JABUNG BARAT', 86, '15', '07'),
(93, 'KAB TANJUNG JABUNG TIMUR', 86, '15', '06'),
(94, 'KAB. BUNGO', 86, '15', '09'),
(95, 'KAB. TEBO', 86, '15', '08'),
(96, 'KOTA JAMBI', 86, '15', '71'),
(97, 'SUMATERA SELATAN', NULL, '16', '00'),
(98, 'KAB. OGAN KOMERING ULU', 97, '16', '01'),
(99, 'KAB. OGAN KOMERING ILIR', 97, '16', '02'),
(100, 'KAB. MUARA ENIM', 97, '16', '03'),
(101, 'KAB. LAHAT', 97, '16', '04'),
(102, 'KAB. MUSI RAWAS', 97, '16', '05'),
(103, 'KAB. MUSI BANYUASIN', 97, '16', '06'),
(104, 'KAB. BANYU ASIN', 97, '16', '07'),
(107, 'KAB. OGAN ILIR', 97, '16', '10'),
(108, 'KAB. EMPAT LAWANG', 97, '16', '11'),
(109, 'KOTA PALEMBANG', 97, '16', '71'),
(110, 'KOTA PAGAR ALAM', 97, '16', '73'),
(111, 'KOTA LUBUKLINGGAU', 97, '16', '74'),
(112, 'KOTA PRABUMULIH', 97, '16', '72'),
(113, 'BENGKULU', NULL, '17', '00'),
(114, 'KAB. BENGKULU SELATAN', 113, '17', '01'),
(115, 'KAB. REJANG LEBONG', 113, '17', '02'),
(116, 'KAB. BENGKULU UTARA', 113, '17', '03'),
(117, 'KAB. KAUR', 113, '17', '04'),
(118, 'KAB. SELUMA', 113, '17', '05'),
(119, 'KAB. MUKOMUKO', 113, '17', '06'),
(120, 'KAB. LEBONG', 113, '17', '07'),
(121, 'KAB. KEPAHIANG', 113, '17', '08'),
(122, 'KOTA BENGKULU', 113, '17', '71'),
(123, 'LAMPUNG', NULL, '18', '00'),
(124, 'KAB. LAMPUNG SELATAN', 123, '18', '03'),
(125, 'KAB. LAMPUNG TENGAH', 123, '18', '05'),
(126, 'KAB. LAMPUNG UTARA', 123, '18', '06'),
(127, 'KAB. LAMPUNG BARAT', 123, '18', '01'),
(128, 'KAB. TULANGBAWANG', 123, '18', '08'),
(129, 'KAB. TANGGAMUS', 123, '18', '02'),
(130, 'KAB. LAMPUNG TIMUR', 123, '18', '04'),
(131, 'KAB. WAY KANAN', 123, '18', '07'),
(132, 'KAB. PESAWARAN', 123, '18', '09'),
(133, 'KOTA BANDAR LAMPUNG', 123, '18', '71'),
(134, 'KOTA METRO', 123, '18', '72'),
(135, 'KEP. BANGKA BELITUNG', NULL, '19', '00'),
(136, 'KAB. BANGKA', 135, '19', '01'),
(137, 'KAB. BELITUNG', 135, '19', '02'),
(138, 'KAB. BANGKA SELATAN', 135, '19', '05'),
(139, 'KAB. BANGKA TENGAH', 135, '19', '04'),
(140, 'KAB. BANGKA BARAT', 135, '19', '03'),
(141, 'KAB. BELITUNG TIMUR', 135, '19', '06'),
(142, 'KOTA PANGKAL PINANG', 135, '19', '71'),
(143, 'KEP. RIAU', NULL, '21', '00'),
(144, 'KAB. BINTAN', 143, '21', '02'),
(145, 'KAB. KARIMUN', 143, '21', '01'),
(146, 'KAB. NATUNA', 143, '21', '03'),
(147, 'KAB. LINGGA', 143, '21', '04'),
(148, 'KOTA BATAM', 143, '21', '71'),
(149, 'KOTA TANJUNG PINANG', 143, '21', '72'),
(150, 'DKI JAKARTA', NULL, '31', '00'),
(151, 'KAB. KEPULAUAN SERIBU', 150, '31', '01'),
(152, 'KOTA JAKARTA PUSAT', 150, '31', '73'),
(153, 'KOTA JAKARTA UTARA', 150, '31', '75'),
(154, 'KOTA JAKARTA BARAT', 150, '31', '74'),
(155, 'KOTA JAKARTA SELATAN', 150, '31', '71'),
(156, 'KOTA JAKARTA TIMUR', 150, '31', '72'),
(157, 'JAWA BARAT', NULL, '32', '00'),
(158, 'KAB. BOGOR', 157, '32', '01'),
(159, 'KAB. SUKABUMI', 157, '32', '02'),
(160, 'KAB. CIANJUR', 157, '32', '03'),
(161, 'KAB. BANDUNG', 157, '32', '04'),
(162, 'KAB. GARUT', 157, '32', '05'),
(163, 'KAB. TASIKMALAYA', 157, '32', '06'),
(164, 'KAB. CIAMIS', 157, '32', '07'),
(165, 'KAB. KUNINGAN', 157, '32', '08'),
(166, 'KAB. CIREBON', 157, '32', '09'),
(167, 'KAB. MAJALENGKA', 157, '32', '10'),
(168, 'KAB. SUMEDANG', 157, '32', '11'),
(169, 'KAB. INDRAMAYU', 157, '32', '12'),
(170, 'KAB. SUBANG', 157, '32', '13'),
(171, 'KAB. PURWAKARTA', 157, '32', '14'),
(172, 'KAB. KARAWANG', 157, '32', '15'),
(173, 'KAB. BEKASI', 157, '32', '16'),
(174, 'KAB. BANDUNG BARAT', 157, '32', '17'),
(175, 'KOTA BOGOR', 157, '32', '71'),
(176, 'KOTA SUKABUMI', 157, '32', '72'),
(177, 'KOTA BANDUNG', 157, '32', '73'),
(178, 'KOTA CIREBON', 157, '32', '74'),
(179, 'KOTA BEKASI', 157, '32', '75'),
(180, 'KOTA DEPOK', 157, '32', '76'),
(181, 'KOTA CIMAHI', 157, '32', '77'),
(182, 'KOTA TASIKMALAYA', 157, '32', '78'),
(183, 'KOTA BANJAR', 157, '32', '79'),
(184, 'JAWA TENGAH', NULL, '33', '00'),
(185, 'KAB. CILACAP', 184, '33', '01'),
(186, 'KAB. BANYUMAS', 184, '33', '02'),
(187, 'KAB. PURBALINGGA', 184, '33', '03'),
(188, 'KAB. BANJARNEGARA', 184, '33', '04'),
(189, 'KAB. KEBUMEN', 184, '33', '05'),
(190, 'KAB. PURWOREJO', 184, '33', '06'),
(191, 'KAB. WONOSOBO', 184, '33', '07'),
(192, 'KAB. MAGELANG', 184, '33', '08'),
(193, 'KAB. BOYOLALI', 184, '33', '09'),
(194, 'KAB. KLATEN', 184, '33', '10'),
(195, 'KAB. SUKOHARJO', 184, '33', '11'),
(196, 'KAB. WONOGIRI', 184, '33', '12'),
(197, 'KAB. KARANGANYAR', 184, '33', '13'),
(198, 'KAB. SRAGEN', 184, '33', '14'),
(199, 'KAB. GROBOGAN', 184, '33', '15'),
(200, 'KAB. BLORA', 184, '33', '16'),
(201, 'KAB. REMBANG', 184, '33', '17'),
(202, 'KAB. PATI', 184, '33', '18'),
(203, 'KAB. KUDUS', 184, '33', '19'),
(204, 'KAB. JEPARA', 184, '33', '20'),
(205, 'KAB. DEMAK', 184, '33', '21'),
(206, 'KAB. SEMARANG', 184, '33', '22'),
(207, 'KAB. TEMANGGUNG', 184, '33', '23'),
(208, 'KAB. KENDAL', 184, '33', '24'),
(209, 'KAB. BATANG', 184, '33', '25'),
(210, 'KAB. PEKALONGAN', 184, '33', '26'),
(211, 'KAB. PEMALANG', 184, '33', '27'),
(212, 'KAB. TEGAL', 184, '33', '28'),
(213, 'KAB. BREBES', 184, '33', '29'),
(214, 'KOTA MAGELANG', 184, '33', '71'),
(215, 'KOTA SURAKARTA', 184, '33', '72'),
(216, 'KOTA SALATIGA', 184, '33', '73'),
(217, 'KOTA SEMARANG', 184, '33', '74'),
(218, 'KOTA PEKALONGAN', 184, '33', '75'),
(219, 'KOTA TEGAL', 184, '33', '76'),
(220, 'DAERAH ISTIMEWA YOGYAKARTA', NULL, '34', '00'),
(221, 'KAB. KULON PROGO', 220, '34', '01'),
(222, 'KAB. BANTUL', 220, '34', '02'),
(223, 'KAB. GUNUNG KIDUL', 220, '34', '03'),
(224, 'KAB. SLEMAN', 220, '34', '04'),
(225, 'KOTA YOGYAKARTA', 220, '34', '71'),
(226, 'JAWA TIMUR', NULL, '35', '00'),
(227, 'KAB. PACITAN', 226, '35', '01'),
(228, 'KAB. PONOROGO', 226, '35', '02'),
(229, 'KAB. TRENGGALEK', 226, '35', '03'),
(230, 'KAB. TULUNGAGUNG', 226, '35', '04'),
(231, 'KAB. BLITAR', 226, '35', '05'),
(232, 'KAB. KEDIRI', 226, '35', '06'),
(233, 'KAB. MALANG', 226, '35', '07'),
(234, 'KAB. LUMAJANG', 226, '35', '08'),
(235, 'KAB. JEMBER', 226, '35', '09'),
(236, 'KAB. BANYUWANGI', 226, '35', '10'),
(237, 'KAB. BONDOWOSO', 226, '35', '11'),
(238, 'KAB. SITUBONDO', 226, '35', '12'),
(239, 'KAB. PROBOLINGGO', 226, '35', '13'),
(240, 'KAB. PASURUAN', 226, '35', '14'),
(241, 'KAB. SIDOARJO', 226, '35', '15'),
(242, 'KAB. MOJOKERTO', 226, '35', '16'),
(243, 'KAB. JOMBANG', 226, '35', '17'),
(244, 'KAB. NGANJUK', 226, '35', '18'),
(245, 'KAB. MADIUN', 226, '35', '19'),
(246, 'KAB. MAGETAN', 226, '35', '20'),
(247, 'KAB. NGAWI', 226, '35', '21'),
(248, 'KAB. BOJONEGORO', 226, '35', '22'),
(249, 'KAB. TUBAN', 226, '35', '23'),
(250, 'KAB. LAMONGAN', 226, '35', '24'),
(251, 'KAB. GRESIK', 226, '35', '25'),
(252, 'KAB. BANGKALAN', 226, '35', '26'),
(253, 'KAB. SAMPANG', 226, '35', '27'),
(254, 'KAB. PAMEKASAN', 226, '35', '28'),
(255, 'KAB. SUMENEP', 226, '35', '29'),
(256, 'KOTA KEDIRI', 226, '35', '71'),
(257, 'KOTA BLITAR', 226, '35', '72'),
(258, 'KOTA MALANG', 226, '35', '73'),
(259, 'KOTA PROBOLINGGO', 226, '35', '74'),
(260, 'KOTA PASURUAN', 226, '35', '75'),
(261, 'KOTA MOJOKERTO', 226, '35', '76'),
(262, 'KOTA MADIUN', 226, '35', '77'),
(263, 'KOTA SURABAYA', 226, '35', '78'),
(264, 'KOTA BATU', 226, '35', '79'),
(265, 'BANTEN', NULL, '36', '00'),
(266, 'KAB. PANDEGLANG', 265, '36', '01'),
(267, 'KAB. LEBAK', 265, '36', '02'),
(268, 'KAB. TANGERANG', 265, '36', '03'),
(269, 'KAB. SERANG', 265, '36', '04'),
(270, 'KOTA TANGERANG', 265, '36', '71'),
(271, 'KOTA CILEGON', 265, '36', '72'),
(272, 'KOTA SERANG', 265, '36', '73'),
(273, 'BALI', NULL, '51', '00'),
(274, 'KAB. JEMBRANA', 273, '51', '01'),
(275, 'KAB. TABANAN', 273, '51', '02'),
(276, 'KAB. BADUNG', 273, '51', '03'),
(277, 'KAB. GIANYAR', 273, '51', '04'),
(278, 'KAB. KLUNGKUNG', 273, '51', '05'),
(279, 'KAB. BANGLI', 273, '51', '06'),
(280, 'KAB. KARANG ASEM', 273, '51', '07'),
(281, 'KAB. BULELENG', 273, '51', '08'),
(282, 'KOTA DENPASAR', 273, '51', '71'),
(283, 'NUSA TENGGARA BARAT', NULL, '52', '00'),
(284, 'KAB. LOMBOK BARAT', 283, '52', '01'),
(285, 'KAB. LOMBOK TENGAH', 283, '52', '02'),
(286, 'KAB. LOMBOK TIMUR', 283, '52', '03'),
(287, 'KAB. SUMBAWA', 283, '52', '04'),
(288, 'KAB. DOMPU', 283, '52', '05'),
(289, 'KAB. BIMA', 283, '52', '06'),
(290, 'KAB. SUMBAWA BARAT', 283, '52', '07'),
(291, 'KOTA MATARAM', 283, '52', '71'),
(292, 'KOTA BIMA', 283, '52', '72'),
(293, 'NUSA TENGGARA TIMUR', NULL, '53', '00'),
(294, 'KAB. KUPANG', 293, '53', '03'),
(295, 'KAB TIMOR TENGAH SELATAN', 293, '53', '04'),
(296, 'KAB. TIMOR TENGAH UTARA', 293, '53', '05'),
(297, 'KAB. BELU', 293, '53', '06'),
(298, 'KAB. ALOR', 293, '53', '07'),
(299, 'KAB. FLORES TIMUR', 293, '53', '09'),
(300, 'KAB. SIKKA', 293, '53', '10'),
(301, 'KAB. ENDE', 293, '53', '11'),
(302, 'KAB. NGADA', 293, '53', '12'),
(303, 'KAB. MANGGARAI', 293, '53', '13'),
(304, 'KAB. SUMBA TIMUR', 293, '53', '02'),
(305, 'KAB. SUMBA BARAT', 293, '53', '01'),
(306, 'KAB. LEMBATA', 293, '53', '08'),
(307, 'KAB. ROTE NDAO', 293, '53', '14'),
(308, 'KAB. MANGGARAI BARAT', 293, '53', '15'),
(309, 'KAB. NAGEKEO', 293, '53', '18'),
(310, 'KAB. SUMBA TENGAH', 293, '53', '16'),
(311, 'KAB. SUMBA BARAT DAYA', 293, '53', '17'),
(312, 'KAB. MANGGARAI TIMUR', 293, '53', '19'),
(313, 'KOTA KUPANG', 293, '53', '71'),
(314, 'KALIMANTAN BARAT', NULL, '61', '00'),
(315, 'KAB. SAMBAS', 314, '61', '01'),
(317, 'KAB. SANGGAU', 314, '61', '05'),
(318, 'KAB. KETAPANG', 314, '61', '06'),
(319, 'KAB. SINTANG', 314, '61', '07'),
(320, 'KAB. KAPUAS HULU', 314, '61', '08'),
(321, 'KAB. BENGKAYANG', 314, '61', '02'),
(322, 'KAB. LANDAK', 314, '61', '03'),
(323, 'KAB. SEKADAU', 314, '61', '09'),
(324, 'KAB. MELAWI', 314, '61', '10'),
(325, 'KAB. KAYONG UTARA', 314, '61', '11'),
(326, 'KAB. KUBU RAYA', 314, '61', '12'),
(327, 'KOTA PONTIANAK', 314, '61', '71'),
(328, 'KOTA SINGKAWANG', 314, '61', '72'),
(329, 'KALIMANTAN TENGAH', NULL, '62', '00'),
(330, 'KAB. KOTAWARINGIN BARAT', 329, '62', '01'),
(331, 'KAB. KOTAWARINGIN TIMUR', 329, '62', '02'),
(332, 'KAB. KAPUAS', 329, '62', '03'),
(333, 'KAB. BARITO SELATAN', 329, '62', '04'),
(334, 'KAB. BARITO UTARA', 329, '62', '05'),
(335, 'KAB. KATINGAN', 329, '62', '09'),
(336, 'KAB. SERUYAN', 329, '62', '08'),
(337, 'KAB. SUKAMARA', 329, '62', '06'),
(338, 'KAB. LAMANDAU', 329, '62', '07'),
(339, 'KAB. GUNUNG MAS', 329, '62', '11'),
(340, 'KAB. PULANG PISAU', 329, '62', '10'),
(341, 'KAB. MURUNG RAYA', 329, '62', '13'),
(342, 'KAB. BARITO TIMUR', 329, '62', '12'),
(343, 'KOTA PALANGKA RAYA', 329, '62', '71'),
(344, 'KALIMANTAN SELATAN', NULL, '63', '00'),
(345, 'KAB. TANAH LAUT', 344, '63', '01'),
(346, 'KAB. KOTABARU', 344, '63', '02'),
(347, 'KAB. BANJAR', 344, '63', '03'),
(348, 'KAB. BARITO KUALA', 344, '63', '04'),
(349, 'KAB. TAPIN', 344, '63', '05'),
(350, 'KAB. HULU SUNGAI SELATAN', 344, '63', '06'),
(351, 'KAB. HULU SUNGAI TENGAH', 344, '63', '07'),
(352, 'KAB. HULU SUNGAI UTARA', 344, '63', '08'),
(353, 'KAB. TABALONG', 344, '63', '09'),
(354, 'KAB. TANAH BUMBU', 344, '63', '10'),
(355, 'KAB. BALANGAN', 344, '63', '11'),
(356, 'KOTA BANJARMASIN', 344, '63', '71'),
(357, 'KOTA BANJAR BARU', 344, '63', '72'),
(358, 'KALIMANTAN TIMUR', NULL, '64', '00'),
(359, 'KAB. PASER', 358, '64', '01'),
(360, 'KAB. KUTAI KARTANEGARA', 358, '64', '03'),
(361, 'KAB. BERAU', 358, '64', '05'),
(362, 'KAB. BULUNGAN', 523, '65', '02'),
(363, 'KAB. NUNUKAN', 523, '65', '04'),
(364, 'KAB. MALINAU', 523, '65', '01'),
(365, 'KAB. KUTAI BARAT', 358, '64', '02'),
(366, 'KAB. KUTAI TIMUR', 358, '64', '04'),
(367, 'KAB. PENAJAM PASER UTARA', 358, '64', '09'),
(368, 'KAB. TANA TIDUNG', 523, '65', '03'),
(369, 'KOTA BALIKPAPAN', 358, '64', '71'),
(370, 'KOTA SAMARINDA', 358, '64', '72'),
(371, 'KOTA TARAKAN', 523, '65', '71'),
(372, 'KOTA BONTANG', 358, '64', '74'),
(373, 'SULAWESI UTARA', NULL, '71', '00'),
(374, 'KAB BOLAANG MONGONDOW', 373, '71', '01'),
(375, 'KAB. MINAHASA', 373, '71', '02'),
(376, 'KAB. KEPULAUAN SANGIHE', 373, '71', '03'),
(377, 'KAB. KEPULAUAN TALAUD', 373, '71', '04'),
(378, 'KAB. MINAHASA SELATAN', 373, '71', '05'),
(379, 'KAB. MINAHASA UTARA', 373, '71', '06'),
(380, 'KAB. MINAHASA TENGGARA', 373, '71', '09'),
(381, 'KAB. BOLAANG MONGONDOW UTARA', 373, '71', '07'),
(383, 'KOTA MANADO', 373, '71', '71'),
(384, 'KOTA BITUNG', 373, '71', '72'),
(385, 'KOTA TOMOHON', 373, '71', '73'),
(386, 'KOTA KOTAMOBAGU', 373, '71', '74'),
(387, 'SULAWESI TENGAH', NULL, '72', '00'),
(388, 'KAB. BANGGAI', 387, '72', '02'),
(389, 'KAB. POSO', 387, '72', '04'),
(390, 'KAB. DONGGALA', 387, '72', '05'),
(391, 'KAB. TOLI-TOLI', 387, '72', '06'),
(392, 'KAB. BUOL', 387, '72', '07'),
(393, 'KAB. MOROWALI', 387, '72', '03'),
(394, 'KAB BANGGAI KEPULAUAN', 387, '72', '01'),
(395, 'KAB. PARIGI MOUTONG', 387, '72', '08'),
(396, 'KAB. TOJO UNA-UNA', 387, '72', '09'),
(397, 'KOTA PALU', 387, '72', '71'),
(398, 'SULAWESI SELATAN', NULL, '73', '00'),
(399, 'KAB. KEPULAUAN SELAYAR', 398, '73', '01'),
(400, 'KAB. BULUKUMBA', 398, '73', '02'),
(401, 'KAB. BANTAENG', 398, '73', '03'),
(402, 'KAB. JENEPONTO', 398, '73', '04'),
(403, 'KAB. TAKALAR', 398, '73', '05'),
(404, 'KAB. GOWA', 398, '73', '06'),
(405, 'KAB. SINJAI', 398, '73', '07'),
(406, 'KAB. BONE', 398, '73', '11'),
(407, 'KAB. MAROS', 398, '73', '08'),
(408, 'KAB. PANGKAJENE DAN KEPULAUAN', 398, '73', '09'),
(409, 'KAB. BARRU', 398, '73', '10'),
(410, 'KAB. SOPPENG', 398, '73', '12'),
(411, 'KAB. WAJO', 398, '73', '13'),
(412, 'KAB. SIDENRENG RAPPANG', 398, '73', '14'),
(413, 'KAB. PINRANG', 398, '73', '15'),
(414, 'KAB. ENREKANG', 398, '73', '16'),
(415, 'KAB. LUWU', 398, '73', '17'),
(416, 'KAB. TANA TORAJA', 398, '73', '18'),
(417, 'KAB. LUWU UTARA', 398, '73', '22'),
(418, 'KAB. LUWU TIMUR', 398, '73', '25'),
(419, 'KOTA MAKASSAR', 398, '73', '71'),
(420, 'KOTA PAREPARE', 398, '73', '72'),
(421, 'KOTA PALOPO', 398, '73', '73'),
(422, 'SULAWESI TENGGARA', NULL, '74', '00'),
(423, 'KAB. KOLAKA', 422, '74', '04'),
(424, 'KAB. KONAWE', 422, '74', '03'),
(425, 'KAB. MUNA', 422, '74', '02'),
(426, 'KAB. BUTON', 422, '74', '01'),
(427, 'KAB. KONAWE SELATAN', 422, '74', '05'),
(428, 'KAB. BOMBANA', 422, '74', '06'),
(429, 'KAB. WAKATOBI', 422, '74', '07'),
(430, 'KAB. KOLAKA UTARA', 422, '74', '08'),
(431, 'KAB. KONAWE UTARA', 422, '74', '10'),
(432, 'KAB. BUTON UTARA', 422, '74', '09'),
(433, 'KOTA KENDARI', 422, '74', '71'),
(434, 'KOTA BAUBAU', 422, '74', '72'),
(435, 'GORONTALO', NULL, '75', '00'),
(436, 'KAB. GORONTALO', 435, '75', '02'),
(437, 'KAB. BOALEMO', 435, '75', '01'),
(438, 'KAB. BONE BOLANGO', 435, '75', '04'),
(439, 'KAB. PAHUWATO', 435, '75', '03'),
(440, 'KAB. GORONTALO UTARA', 435, '75', '05'),
(441, 'KOTA GORONTALO', 435, '75', '71'),
(442, 'SULAWESI BARAT', NULL, '76', '00'),
(443, 'KAB. MAMUJU UTARA', 442, '76', '05'),
(444, 'KAB. MAMUJU', 442, '76', '04'),
(445, 'KAB. MAMASA', 442, '76', '03'),
(446, 'KAB. POLEWALI MANDAR', 442, '76', '02'),
(447, 'KAB. MAJENE', 442, '76', '01'),
(448, 'MALUKU', NULL, '81', '00'),
(449, 'KAB. MALUKU TENGAH', 448, '81', '03'),
(450, 'KAB. MALUKU TENGGARA', 448, '81', '02'),
(451, 'KAB. MALUKU TENGGARA BARAT', 448, '81', '01'),
(452, 'KAB. BURU', 448, '81', '04'),
(453, 'KAB. SERAM BAGIAN TIMUR', 448, '81', '07'),
(454, 'KAB. SERAM BAGIAN BARAT', 448, '81', '06'),
(455, 'KAB. KEPULAUAN ARU', 448, '81', '05'),
(456, 'KOTA AMBON', 448, '81', '71'),
(457, 'KOTA TUAL', 448, '81', '71'),
(458, 'MALUKU UTARA', NULL, '82', '00'),
(459, 'KAB. HALMAHERA BARAT', 458, '82', '01'),
(460, 'KAB. HALMAHERA TENGAH', 458, '82', '02'),
(461, 'KAB. HALMAHERA UTARA', 458, '82', '05'),
(462, 'KAB. HALMAHERA SELATAN', 458, '82', '04'),
(463, 'KAB. KEPULAUAN SULA', 458, '82', '03'),
(464, 'KAB. HALMAHERA TIMUR', 458, '82', '06'),
(465, 'KOTA TERNATE', 458, '82', '71'),
(466, 'KOTA TIDORE KEPULAUAN', 458, '82', '72'),
(467, 'PAPUA', NULL, '94', '00'),
(468, 'KAB. MERAUKE', 467, '94', '01'),
(469, 'KAB. JAYAWIJAYA', 467, '94', '02'),
(470, 'KAB. JAYAPURA', 467, '94', '03'),
(471, 'KAB. NABIRE', 467, '94', '04'),
(473, 'KAB. BIAK NUMFOR', 467, '94', '09'),
(474, 'KAB. PUNCAK JAYA', 467, '94', '11'),
(475, 'KAB. PANIAI', 467, '94', '10'),
(476, 'KAB. MIMIKA', 467, '94', '12'),
(477, 'KAB. SARMI', 467, '94', '19'),
(478, 'KAB. KEEROM', 467, '94', '20'),
(479, 'KAB. PEGUNUNGAN BINTANG', 467, '94', '17'),
(480, 'KAB. YAHUKIMO', 467, '94', '16'),
(481, 'KAB. TOLIKARA', 467, '94', '18'),
(482, 'KAB. WAROPEN', 467, '94', '26'),
(483, 'KAB. BOVEN DIGOEL', 467, '94', '13'),
(484, 'KAB. MAPPI', 467, '94', '14'),
(485, 'KAB. ASMAT', 467, '94', '15'),
(486, 'KAB. SUPIORI', 467, '94', '27'),
(487, 'KAB. MAMBERAMO RAYA', 467, '94', '28'),
(488, 'KOTA JAYAPURA', 467, '94', '71'),
(489, 'PAPUA BARAT', NULL, '91', '00'),
(490, 'KAB. SORONG', 489, '91', '07'),
(491, 'KAB. MANOKWARI', 489, '91', '05'),
(492, 'KAB. FAKFAK', 489, '91', '01'),
(493, 'KAB. SORONG SELATAN', 489, '91', '06'),
(494, 'KAB. RAJA AMPAT', 489, '91', '08'),
(495, 'KAB. TELUK BENTUNI', 489, '91', '04'),
(496, 'KAB. TELUK WONDAMA', 489, '91', '03'),
(497, 'KAB. KAIMANA', 489, '91', '02'),
(498, 'KOTA SORONG', 489, '91', '71'),
(499, 'KAB. LABUHAN BATU SELATAN', 25, '12', '22'),
(500, 'KAB. LABUHAN BATU UTARA', 25, '12', '23'),
(501, 'KAB. NIAS UTARA', 25, '12', '24'),
(502, 'KAB. NIAS BARAT', 25, '12', '25'),
(503, 'KOTA GUNUNGSITOLI', 25, '12', '78'),
(504, 'KAB. KEPULAUAN MERANTI', 74, '14', '10'),
(505, 'KOTA SUNGAI PENUH', 86, '15', '72'),
(506, 'KAB. OGAN KOMERING ULU SELATAN', 97, '16', '08'),
(507, 'KAB. OGAN KOMERING ULU TIMUR', 97, '16', '09'),
(508, 'KAB. PENUKAL ABAB LEMATANG ILIR', 97, '16', '12'),
(509, 'KAB. MUSI RAWAS UTARA', 97, '16', '13'),
(510, 'KAB. BENGKULU TENGAH', 113, '17', '09'),
(511, 'KAB. PRINGSEWU', 123, '18', '10'),
(512, 'KAB. MESUJI', 123, '18', '11'),
(513, 'KAB. TULANG BAWANG BARAT', 123, '18', '12'),
(514, 'KAB. PESISIR BARAT', 123, '18', '13'),
(515, 'KAB. KEPULAUAN ANAMBAS', 143, '21', '05'),
(516, 'KAB. PANGANDARAN', 157, '32', '18'),
(517, 'KOTA TANGERANG SELATAN', 265, '36', '74'),
(518, 'KAB. LOMBOK UTARA', 283, '52', '08'),
(519, 'KAB. SABU RAIJUA', 293, '53', '20'),
(520, 'KAB. MALAKA', 293, '53', '21'),
(521, 'KAB. MEMPAWAH', 314, '61', '04'),
(522, 'KAB. MAHAKAM HULU', 358, '64', '11'),
(523, 'KALIMANTAN UTARA', NULL, '65', '00'),
(524, 'KAB. SIAU TAGULANDANG BIARO', 373, '71', '08'),
(525, 'KAB. BOLAANG MONGONDOW SELATAN', 373, '71', '10'),
(526, 'KAB. BOLAANG MONGONDOW TIMUR', 373, '71', '11'),
(527, 'KAB. SIGI', 387, '72', '10'),
(528, 'KAB. BANGGAI LAUT', 387, '72', '11'),
(529, 'KAB. MOROWALI UTARA', 387, '72', '12'),
(530, 'KAB. TORAJA UTARA', 398, '73', '26'),
(531, 'KAB. KOLAKA TIMUR', 422, '74', '11'),
(532, 'KAB. KONAWE KEPULAUAN', 422, '74', '12'),
(533, 'KAB. MUNA BARAT', 422, '74', '13'),
(534, 'KAB. BUTON TENGAH', 422, '74', '14'),
(535, 'KAB. BUTON SELATAN', 422, '74', '15'),
(536, 'KAB. MAMUJU TENGAH', 442, '76', '06'),
(537, 'KAB. MALUKU BARAT DAYA', 448, '81', '08'),
(538, 'KAB. BURU SELATAN', 448, '81', '09'),
(539, 'KAB. PULAU MOROTAI', 458, '82', '07'),
(540, 'KAB. PULAU TALIABU', 458, '82', '08'),
(541, 'KAB. TAMBRAUW', 489, '91', '09'),
(542, 'KAB. MAYBRAT', 489, '91', '10'),
(543, 'KAB. MANOKWARI SELATAN', 489, '91', '11'),
(544, 'KAB. PEGUNUNGAN ARFAK', 489, '91', '12'),
(545, 'KAB. KEPULAUAN YAPEN', 467, '94', '08'),
(546, 'KAB. NDUGA', 467, '94', '29'),
(547, 'KAB. LANNY JAYA', 467, '94', '30'),
(548, 'KAB. MAMBERAMO TENGAH', 467, '94', '31'),
(549, 'KAB. YALIMO', 467, '94', '32'),
(550, 'KAB. PUNCAK', 467, '94', '33'),
(551, 'KAB. DOGIYAI', 467, '94', '34'),
(552, 'KAB. INTAN JAYA', 467, '94', '35'),
(553, 'KAB. DEIYAI', 467, '94', '36');

--
-- Dumping database for table `religions`
--

INSERT INTO `religions` (`religion_id`, `religion_name`) VALUES
(1, 'Kristen'),
(2, 'Katolik'),
(3, 'Islam'),
(4, 'Hindu'),
(5, 'Buddha'),
(6, 'Others');

--
-- Dumping database for table `roles`
--

INSERT INTO `roles` (`role_id`, `title_alias`, `deleted`) VALUES
('admin-regional', 'Administrator Regional', 'N'),
('admin-super', 'Administrator General', 'N'),
('member', 'Member', 'N'),
('volunteer', 'Author Voluntary', 'N');

--
-- Dumping database for table `skills`
--

INSERT INTO `skills` (`skill_id`, `parent_id`, `skill_name`, `created`, `modified`, `deleted`) VALUES
(1, NULL, 'Software Development', '2015-11-22 14:11:01', NULL, 'N'),
(2, 1, 'PHP', '2015-11-22 14:11:01', NULL, 'N'),
(3, 1, 'Java Web (JEE)', '2015-11-22 14:11:01', NULL, 'N'),
(4, 1, 'Java Mobile Android', '2015-11-22 14:11:01', NULL, 'N'),
(5, 1, 'Java Desktop', '2015-11-22 14:11:01', NULL, 'N'),
(6, 1, 'Java Other', '2015-11-22 14:11:01', NULL, 'N'),
(7, 1, 'iOS Mobile Apps Development', '2015-11-22 14:11:01', NULL, 'N'),
(8, 1, 'Python', '2015-11-22 14:11:01', NULL, 'N'),
(9, 1, 'Ruby', '2015-11-22 14:11:01', NULL, 'N'),
(10, 1, 'Perl', '2015-11-22 14:11:01', NULL, 'N'),
(11, 1, '.NET', '2015-11-22 14:11:01', NULL, 'N'),
(12, 1, 'Scala', '2015-11-22 14:11:01', NULL, 'N'),
(13, 1, 'Erlang', '2015-11-22 14:11:01', NULL, 'N'),
(14, 1, 'Visual Basic 6', '2015-11-22 14:11:01', NULL, 'N'),
(15, NULL, 'UI / UX', '2015-11-22 14:11:01', NULL, 'N'),
(16, 15, 'HTML & CSS', '2015-11-22 14:11:01', NULL, 'N'),
(17, 15, 'Javacript (ECMA Script) General', '2015-11-22 14:11:01', NULL, 'N'),
(18, 15, 'jQuery Javascript Framework', '2015-11-22 14:11:01', NULL, 'N'),
(19, 15, 'Other Javascript Framework', '2015-11-22 14:11:01', NULL, 'N'),
(20, 15, 'Photoshop General', '2015-11-22 14:11:01', NULL, 'N'),
(21, 15, 'Photoshop Web Design', '2015-11-22 14:11:01', NULL, 'N'),
(22, 15, 'CorelDraw General', '2015-11-22 14:11:01', NULL, 'N'),
(23, NULL, 'Database System', '2015-11-22 14:11:01', NULL, 'N'),
(24, 23, 'MySQL', '2015-11-22 14:11:01', NULL, 'N'),
(25, 23, 'PostgreSQL', '2015-11-22 14:11:01', NULL, 'N'),
(26, 23, 'Oracle', '2015-11-22 14:11:01', NULL, 'N'),
(27, 23, 'Microsoft SQL', '2015-11-22 14:11:01', NULL, 'N'),
(28, 23, 'NoSQL Products', '2015-11-22 14:11:01', NULL, 'N'),
(29, NULL, 'Computer Networking', NULL, NULL, 'N'),
(30, 29, 'General Computer Networking', NULL, NULL, 'N'),
(31, 29, 'Linux Server Administer', NULL, NULL, 'N'),
(32, 29, 'Windows Server Administer', NULL, NULL, 'N'),
(33, NULL, 'Microcontroller', NULL, NULL, 'N'),
(34, 1, 'ANSI C', NULL, NULL, 'N'),
(35, 1, 'C++', NULL, NULL, 'N'),
(36, NULL, 'Software System Analyst', NULL, NULL, 'N'),
(37, NULL, 'Computer Hardware', NULL, NULL, 'N'),
(38, 37, 'Computer Assemblying', NULL, NULL, 'N'),
(39, 37, 'Computer Problem Troubleshooting', NULL, NULL, 'N'),
(40, 37, 'Computer Overclocking', NULL, NULL, 'N'),
(41, 37, 'Printer Repair', NULL, NULL, 'N');