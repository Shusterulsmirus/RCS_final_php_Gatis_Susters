-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2022 at 05:54 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rcs_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `servings` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `ingredients` varchar(255) NOT NULL,
  `preparation` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `publish_date` datetime NOT NULL,
  `image` mediumtext NOT NULL,
  `gallery` longtext NOT NULL DEFAULT '[]',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `to_hide` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `excerpt`, `type`, `servings`, `duration`, `ingredients`, `preparation`, `user_id`, `publish_date`, `image`, `gallery`, `is_deleted`, `to_hide`) VALUES
(9, 'Pikantā omlete ar desiņām', 'Omlete ir ideāls ēdiens gan brokastīs, gan pusdienās, gan vakariņās. Ātri, vienkārši, un var dažādot garšas. Es šoreiz izmantoju dažādas desiņas (“Mednieku” un ar sieru), un var pamēģināt svaiga čili vietā marinētus peperončini.', 'Brokastis', '3', '25', '4 olas\r\n125 g kūpinātu desiņu\r\n1/2 sarkanās paprikas\r\n1 svaigs čili\r\n1 sīpols\r\n1 daiviņa/s ķiploka\r\n30 g labi kūstoša siera\r\n30 ml piena\r\n30 g pesto\r\n1 ēd. k. eļļas\r\nsāls\r\npipari', '1. Sīpolu sagriež mazos kubiņos. Ķiploku sasmalcina. Papriku sagriež strēmelītēs. Čili sagriež uz pusēm un izņem sēklas, tad sagriež strēmelītēs. Desiņas sagriež smalkāk.\r\n2. Olām pievieno pienu un ar dakšu sakuļ. Pēc garšas pievieno sāli un svaigi maltus', 1, '2022-11-20 23:30:22', '4A0C.tmp.png', '[]', 0, 1),
(10, 'Kraukšķīgās tīģergarneles', 'Kraukšķīgā kažociņā ietērpta pasakaina garnele. Lai garšīgāk - jāpasniedz ar īsto majonēzi!', 'Uzkodas', '4', '30', '30 tīģergarneles\r\n1 ola\r\n200 g miltu\r\n100 ml piena\r\npanko rīvmaize\r\nsāls\r\npipari\r\npūšamā eļļa', '1. Tīģergarneles noloba no čaulām, atstāj tikai astītes.\r\n2. Sagatavo trīs traukus panēšanai. Vienā lēzenā traukā ber 100 g miltu, sāli, piparus, un visu samaisa.\r\n3. Otrā nelielā bļodiņā sajauc mīklu – iesit olu, sakuļ, pievieno pienu un tad pakāpeniski ', 1, '2022-11-20 23:34:31', '14E3.tmp.png', '[]', 0, 0),
(11, 'Kreptīgais kartupeļu biezenis', 'Kartupeļu biezenis ar mērci - garšīgi. Bet ja pievieno pērļu grūbas, tas kļūst kreptīgāks un tev virtuvē parādās jaunas garšas.', 'Pamatēdiens', '4', '50', '6-7 kartupeļi\r\n1 paciņa pērļu grūbu\r\n100 g žāvētas gaļas\r\n1 sīpols\r\n100 ml piena\r\n1 ēd. k. sviesta\r\npēc garšas sāls\r\nzaļumi', '1. Kartupeļus nomizo, izvāra mīkstus, tāpat izvāra arī pērļu grūbas.\r\n2. Kamēr kartupeļi vārās, sagriež gabaliņos un apcep gaļu ar sīpoliem.\r\n3. Kad kartupeļi izvārījušies, tiem pievieno sviestu, pienu (nedaudz uzsilda) un samīca biezenī.\r\n4. Tad biezenim', 1, '2022-11-20 23:37:17', '9CD8.tmp.png', '[]', 0, 0),
(12, 'Fetas pasta ar tomātiem', 'Salasījos internetā par jaunāko TikTok trendu - feta pasta. Viegli uztaisīt un ļoti garšīgi.', 'Pamatēdiens', '2', '40', '100 g fetas siers\r\n200 g ķiršu tomāts\r\n1/2 sauja baziliks\r\n2 daiviņa/s ķiploks\r\n125 g makaroni\r\nolīveļļa', '1. Ieliek sieru, tomātus, baziliku un sasmalcinātus ķiplokus cepamā traukā. Apslaka ar olīveļļu.\r\n2. Cep cepeškrāsnī 200C grādos 30 minūtes.\r\n3. Kamēr feta cepas, uzvāra makaronus. Paglabā pāris ēdamkarotes ūdens, kur makaroni vārījās.\r\n4. Kad feta gatava', 2, '2022-11-20 23:40:18', '5FB3.tmp.png', '[]', 0, 0),
(13, 'Slinkais rāmens bez vārīšanas', 'Pagatavot “slinko” rāmenu ir vienkāršāk par vienkāršu – visas sastāvdaļas saliec bļodiņās, pārlej ar verdošu buljonu un 10 minūtes ļauj savilkties garšām. Zupas gatavošanai vari izmantot arī iepriekšējās dienas cepeti, kā arī šašlika vai karbonādes strēme', 'Zupa', '2', '20', '1 vistas fileja\r\n1 kubiņš liellopa buljona GALLINA BLANCA\r\n2 vārītas olas\r\n1 sauja nevārītu smalko rīsu nūdeļu\r\n1/2 paprika\r\n1 sauja spināti\r\n1 sarkanais sīpols\r\n1 tējk. ingvers, rīvēts\r\n2 ēd. k. laima sula\r\n500 ml verdoša ūdens\r\n2 ēd. k. saldās čili mērc', '1. Gaļu ar gaļas āmuriņa plakano pusi viegli saplacina, lai tā būtu aptuveni vienādā biezumā, liek bļodiņa, pārlej ar sojas mērci apmaisa. Ļauj ievilkties.\r\n2. Pa to laiku olas noloba, pārgriež uz pusēm. Sarkano sīpolu sagriež ļoti plānos pusgredzenos. Pa', 2, '2022-11-20 23:43:04', 'E827.tmp.png', '[]', 0, 0),
(14, 'Ātrais \"Snickers\" deserta kārtojums', 'Ja tev garšo \"Snickers\", tad noteikti pagatavo šo kārdinošo desertu!', 'Deserts', '2', '20', '1 paciņa \"Selgas\" šokolādes cepumu\r\npēc garšas \"Spilvas\" karameļu mērce\r\nsālīti zemesrieksti\r\n200 ml saldais krējums 35 %\r\n1/2 bundžiņa iebiezinātais piens ar cukuru', '1. Cepumus sablendē līdz smilšu konsistencei. Zemesriekstus nedaudz sasmalcina.\r\n2. Gatavo krēmu. Sakuļ saldo krējumu stingrās putās, iemaisa iebiezināto pienu.\r\n3. Stikla trauciņā vai burkā kārtām liek: cepumus, iebiezinātā piena krēmu, karameli, nedaudz', 2, '2022-11-20 23:53:43', 'A91C.tmp.png', '[]', 0, 0),
(15, 'Ķirbju siera kūka', 'Ķirbis siera kūkā? Jā! Garšo pasakaini!', 'Konditoreja', '10', '720', '1 kg konditorejas biezpiens\r\n250 g Maskarpone\r\n3 olas\r\n250 g cukura\r\n3 ēd. k. kartupeļu cietas\r\n500 g cepts Hokkaido ķirbis\r\n\r\nPamatnei:\r\ncepumi\r\nsviests', '1. Cepumus sasmalcina un sajauc ar kausētu sviestu.\r\n2. Cepto ķirbi sablendē. Sajauc kopā ar pārējām sastāvdaļām un liek uz cepumu masas.\r\n3. Cep 180 grādos (augša/apakša) vidus plauktā. Aptuveni 60 minūtes (man sanāca drusku ilgāk). Vislabāk garšo nākama', 3, '2022-11-20 23:56:41', '61D7.tmp.png', '[]', 0, 1),
(16, 'Tarte ar mellenēm', 'Formas diametrs 24 cm.', 'Konditoreja', '12', '60', 'Mīklai:\r\n160 g milti\r\n100 g sviests\r\n70 g skābais krējums\r\n1 tējk. cepamais pulveris\r\nšķipsna/s sāls\r\n\r\nPildījumam:\r\n250 g skābais krējums\r\n1 ola\r\n180 g mellene\r\n130 g cukurs\r\n2 ēd. k. kukurūzas vai kartupeļu cietes\r\n1 ēd. k. vaniļas cukurs', '1. Istabas temperatūras sviestu saputo ar skābo krējumu līdz viendabīgai masai. Pieber izsijātus miltus, cepamo pulveri, sāli un samīca mīklu.\r\n2. Formā ieklāj mīklu, veidojot dibenu un augstas malas. Sadursta dibenu ar dakšiņu.\r\n3. Skābo krējumu saputo a', 3, '2022-11-20 23:57:44', '56D8.tmp.png', '[]', 0, 0),
(17, 'Cepumu “Svetlana” liesā versija', 'Kurš gan nezina Svetlanu? Nē, nevis kādu dāmu, bet īpašo cepumu. Šī versija būs figūrai draudzīgāka, jo iebiezināto pienu aizstāj krēmsiers un dateles. Nav izmantoti arī kviešu milti, tāpēc draudzīga tiem, kuri ar glutēnu \"uz jūs\".', 'Konditoreja', '6', '35', 'Cepumam:\r\n120 g rīsu milti\r\n2 ola\r\n1-2 ēd. k. stēvija\r\n1 ēd. k. kokosriekstu eļļa\r\n1/2 tējk. cepamais pulveris\r\n\r\nPildījums:\r\n180 g datele\r\n180 g krēmsiers\r\n\r\nGlazūrai:\r\n100 g melnā šokolāde', '1. Bļodā sajauc visas cepuma sastāvdaļas, kārtīgi samaisa un masu lej uz paplātes cepamā papīra. Ar silikona lāpstiņu vienmērīgi izlīdzina taisnstūra formā un liek 180 grādos cepties uz aptuveni 10-15 minūtēm.\r\n2. Kad cepumu masa gatava, izņem, un kamēr t', 3, '2022-11-20 23:58:51', '5E28.tmp.png', '[]', 0, 0),
(18, 'Kartupeļu un avokado salāti', 'Kartupeļi lieliski sader avokado. Ja tev ledusskapī ir vakar vārīti kartupeļi - droši izmanto tos.', 'Salāti', '4', '30', '600 g kartupeļu\r\n2 avokado\r\n225 g kukurūzu vālīšu ICA Asia\r\n1 sauja ķiploku, biešu vai rukolas asnu\r\n1 sauja konservētu ICA pupiņu asnu\r\n\r\nMērcei:\r\n1 olas dzeltenums\r\n1 tējk. dižonas sinepju\r\n1 tējk. citrona sulas\r\n30 ml vīnogu kauliņu eļļas\r\n2 ēd. k. mēr', '1. Katlā liek kartupeļus ar ūdeni un vāra, kamēr gatavi. Nokāš, atdzesē.\r\n2. Kamēr dziest, sagatavo mērci. Bļodā liek olas dzeltenumu, sinepes, citrona sulu un samaisa ar rokas putojamo slotiņu. Visu laiku maisot, lej lēnām klāt eļļu un izveidosies majonē', 1, '2022-11-21 03:37:54', 'EA32.tmp.png', '[\'EA33.tmp.png\',\'EA34.tmp.png\']', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `subscribe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscribe`
--

INSERT INTO `subscribe` (`id`, `subscribe`) VALUES
(1, 'gatis.susters@gmail.com'),
(2, 'gatis@mail.com'),
(3, 'gatis@gmail.com'),
(4, 'ilze@mail.com'),
(5, 'ilze@email.com'),
(6, 'janis@mail.com'),
(7, 'maris@epasts.lv'),
(8, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `following` longtext NOT NULL DEFAULT '[]',
  `followers` longtext NOT NULL DEFAULT '[]',
  `blocked` longtext NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `following`, `followers`, `blocked`) VALUES
(1, 'shusts', 'shusts@mail.com', '$2y$10$7DHrVaMAsXHPivfYUJQ.ZOBmK89JObCow7Iwkas2cNyDQbc6wMrYm', '[]', '[\'3\']', '[]'),
(2, 'gatis', 'gatis@mail.com', '$2y$10$nVCVXwJQxXw0INt6a1l9ye4Tw.hQpcDC1.mFAq3ssZp9cvjydnglu', '[]', '[]', '[]'),
(3, 'Ilze', 'Ilze@mail.com', '$2y$10$L2neuQsXN1Ohi7XNmwbJUOsc59ZLuvcEXD1aSle1wJjpqBa3vdgYa', '[\'1\']', '[]', '[]'),
(4, 'Pauls', 'pauls@mail.com', '$2y$10$6K8C7IhHvnvtRZmpVA.fhurK4y2FzbRRGiTcc4TScTGANpppNCNje', '[]', '[]', '[]'),
(5, 'Maris', 'maris.kanis@email.lv', '$2y$10$3uOv777xSx52E7J1w/MsOuPK9PK1I/3JNoncFE7LPllVj4mO003wW', '[]', '[]', '[]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD UNIQUE KEY `email` (`subscribe`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
