-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 02:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booklin`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `OTP` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `email`, `password`, `OTP`, `phone`) VALUES
(2, 'adhithyan', 'adhithyanvm85@gmail.com', 'appuappu1234', NULL, '8590999595');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default-author.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `featured_until` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `name`, `bio`, `image`, `created_at`, `featured_until`) VALUES
(1, 'william shakespeare', 'William Shakespeare was a highly influential English playwright, poet, and actor, widely regarded as the greatest writer in the English language. Born in Stratford-upon-Avon in 1564, he wrote numerous timeless comedies, histories, and tragedies, including famous works like Romeo and Juliet, Hamlet, and Macbeth. He was a member and later a partner in the Lord Chamberlain\'s Men, a theatrical company that owned London\'s famous Globe Theatre. Shakespeare\'s plays explored complex human emotions and universal themes, and his work introduced thousands of new words and phrases into the English language. He died in 1616, but his enduring legacy continues to captivate audiences and influence literature and theatre worldwide.', '1758737312_williamshakesphere\'.jpeg', '2025-09-24 18:08:32', '2025-11-08 16:15:06'),
(3, 'erik barendsen', 'Erik Barendsen is Professor of Computer Science Education at the Open University, the Netherlands, and Professor of Science Education at Radboud University, the Netherlands', '1762418079_eb.jpeg', '2025-11-06 08:34:39', '2025-11-08 16:15:33'),
(4, 'leo tolstoy', 'Leo Tolstoy (1828–1910) was a monumental figure in world literature, celebrated primarily for his epic novels War and Peace and Anna Karenina. Born into Russian aristocracy, he explored profound themes of human existence, morality, and social justice through his writing. A complex man, he later became a radical Christian anarchist and pacifist, advocating for simple living and non-violent resistance, leaving a legacy that extends far beyond literature to influence major political and spiritual leaders like Mahatma Gandhi.', '1762611195_leo.jpeg', '2025-11-08 14:13:15', '2025-11-08 17:13:15'),
(5, 'agatha christie', 'The “Queen of Crime”, author of detective classics like And Then There Were None and Murder on the Orient Express. Her works have been translated into hundreds of languages and she’s ranked as the most-translated individual author.', '1762611288_Agatha_Christie.png', '2025-11-08 14:14:48', '2025-11-08 17:14:48'),
(6, 'Jules Verne ', 'Jules Verne (1828–1905) was a pioneering French novelist, poet, and playwright widely celebrated as a founding father of science fiction. His enduring legacy rests on his Voyages extraordinaires series, which blended thrilling adventures—such as the underwater voyages in Twenty Thousand Leagues Under the Seas and the global dash in Around the World in Eighty Days—with visionary scientific concepts decades ahead of their time. Verne is one of the world\'s most translated authors, and his imaginative work has inspired countless scientists, explorers, and future writers, solidifying his impact on both literature and technological imagination.', '1762611404_jules_verne.jpeg', '2025-11-08 14:16:44', '2025-11-08 17:16:44'),
(7, 'Jane Austen ', 'Jane Austen was an influential English novelist celebrated for her six major works, including Pride and Prejudice and Emma. She is renowned for her witty social commentary, realistic portrayal of the British gentry, and exploration of themes such as marriage, social class, and women\'s roles in early 19th-century society. Her mastery of irony, character development, and narrative technique has ensured her lasting legacy as a literary icon whose stories continue to be widely read and adapted.', '1762611496_jane_austin.jpeg', '2025-11-08 14:18:16', '2025-11-08 17:18:16'),
(8, 'Vaikom Muhammad Basheer', 'Vaikom Muhammad Basheer (1908–1994), affectionately known as the \"Beypore Sultan,\" was an iconic Indian writer and freedom fighter in Malayalam literature. Celebrated for his unique, down-to-earth narrative style and use of colloquial language, Basheer championed humanist values and social critique through stories that blended humor and pathos. His major works, such as Pathummayude Aadu and Mathilukal, remain beloved for their profound simplicity and universal themes of love, life, and the human condition.', '1762611622_vmb.webp', '2025-11-08 14:20:22', '2025-11-08 17:20:22'),
(9, 'M. T. Vasudevan Nair', 'M. T. Vasudevan Nair (15 July 1933 – 25 December 2024), affectionately known as \"MT,\" was a quintessential Indian literary giant, screenwriter, and film director whose work primarily focused on the social and emotional intricacies of Kerala\'s changing traditional society. A master of Malayalam literature, his magnum opus Randamoozham is renowned for its nuanced retelling of the Mahabharata. MT was a recipient of India\'s highest literary honor, the Jnanpith Award, and his extensive film career earned him four National Film Awards for Best Screenplay, cementing his legacy as one of the most influential cultural figures in modern India.', '1762611693_mt.webp', '2025-11-08 14:21:33', '2025-11-08 17:21:33'),
(10, 'M Mukundan', 'M. Mukundan is a highly regarded Indian author and a leading figure in modern Malayalam literature, often called \"Mayyazhiyude Kathakaaran\" (Mayyazhi\'s storyteller) due to his novels frequently being set in his hometown of Mahé. A former cultural attaché at the French Embassy in Delhi, he is celebrated for works like Mayyazhippuzhayude Theerangalil and Delhi: A Soliloquy, the latter of which won the 2021 JCB Prize for Literature. His significant contributions to literature have earned him numerous prestigious awards, including the Sahitya Akademi Award and the Ezhuthachan Puraskaram.', '1762611781_mm.jpeg', '2025-11-08 14:23:01', '2025-11-08 17:23:01'),
(11, 'K. R. Meera', 'K. R. Meera is an acclaimed Indian author and journalist who writes in Malayalam and is a leading voice in contemporary Indian literature. Born in Sasthamkotta, Kerala, she began her career as the first female journalist at the newspaper Malayala Manorama in 1993, where she earned several awards for her investigative series on social issues, particularly women\'s rights and child labor. She resigned from journalism in 2006 to focus entirely on fiction writing, exploring complex themes of identity, gender, and societal norms in her work.', '1762611837_meera.jpeg', '2025-11-08 14:23:57', '2025-11-08 17:23:57'),
(12, 'Benyamin', 'Benyamin is the pen name of Benny Daniel, a prominent contemporary Indian author who writes in the Malayalam language. He is best known for his award-winning novel, Goat Days (Aadujeevitham), a powerful and harrowing tale based on the true story of an Indian migrant worker enslaved in a remote Middle Eastern desert. His writings often delve into the lives of marginalized individuals and the socio-political realities of migration and displacement, themes informed by his own two decades spent as an expatriate in Bahrain. Benyamin has received several prestigious literary awards for his works, including the inaugural JCB Prize for Literature for his novel Jasmine Days.', '1762611912_ben.jpeg', '2025-11-08 14:25:13', '2025-11-08 17:25:12'),
(13, 'Changampuzha Krishna Pillai', 'Changampuzha Krishna Pillai was a celebrated Malayalam poet from Kerala, India, known for his elegy Ramanan which was written in 1936 and sold over 100,000 copies. It is a long pastoral elegy, a play written in the form of verse, allegedly based on the life of Changampuzha\'s friend Edappally Raghavan Pillai.', '1762612099_pillaic.jpeg', '2025-11-08 14:28:19', '2025-11-08 17:28:19'),
(14, 'Kumaran Asan', 'Kumaran Asan (1873–1924) was a seminal poet, philosopher, and social reformer in Malayalam literature, widely regarded as one of the three great poets who revolutionized modern Malayalam poetry. Known by the honorific \"Mahakavi,\" he transformed the genre from a traditional, metaphysical style to a lyrical one focused on human emotions and critical social issues, particularly the caste system and social injustice. A disciple of Sree Narayana Guru, Asan used influential works like Veena Poovu, Duravastha, and Chintaavishtayaaya Seetha to advocate for equality and the upliftment of marginalized communities. He died tragically in a 1924 boat accident, leaving a lasting legacy as a voice of social change and poetic innovation.', '1762612176_asan.jpeg', '2025-11-08 14:29:36', '2025-11-08 17:29:36'),
(15, 'Sugathakumari', 'Sugathakumari (1934–2020) was a highly respected Indian poet and activist known as the \"conscience keeper\" of Kerala society. She made significant contributions to Malayalam literature with acclaimed poetry collections such as Raathrimazha (Night Rain) and Manalezhuthu (The Writing on the Sand), earning top honors like the Padma Shri and Saraswati Samman. Beyond her literary prowess, she was a pioneering environmental activist, leading the successful \"Save Silent Valley\" movement to protect a pristine rainforest, and founded \"Abhaya,\" an organization providing refuge for destitute women and the mentally ill.', '1762612266_Sugathakumari.jpeg', '2025-11-08 14:31:06', '2025-11-08 17:31:06'),
(16, 'Arundhati Roy', 'Arundhati Roy is a celebrated Indian author and a committed political activist, best known for her debut novel, The God of Small Things (1997), which won the Booker Prize and brought her international fame. While her fiction is critically acclaimed, she has primarily dedicated her career to non-fiction writing and social advocacy, addressing pressing human rights and environmental issues in India and globally. Her work is characterized by fierce criticism of government policies, globalization, and injustice, often generating significant public debate. She recently returned to fiction with The Ministry of Utmost Happiness (2017) and continues to be a prominent voice in both literature and activism.', '1762612418_Arundhati_Roy.jpeg', '2025-11-08 14:33:38', '2025-11-08 17:33:38'),
(17, 'Anita Nair', 'Anita Nair (born 26 January 1966) is an acclaimed Indian English-language writer known for her diverse works including novels, poetry, essays, and crime fiction. Her internationally translated novels, such as The Better Man and Ladies Coupé, often explore the lives and experiences of Indian women. Nair has published numerous books, including the Inspector Gowda crime fiction series, and her novel Lessons in Forgetting was adapted into a National Award-winning film. Beyond writing, she founded the mentorship program \"Anita\'s Attic\" and serves as a supporter for UNHCR India.', '1762612479_anita.webp', '2025-11-08 14:34:39', '2025-11-08 17:34:39'),
(18, 'Jeet Thayil', 'Jeet Thayil is an acclaimed Indian author, known primarily for his debut novel Narcopolis (2012), which was shortlisted for the Man Booker Prize and won the DSC Prize for South Asian Literature. A versatile writer, he is also an accomplished poet whose collection These Errors Are Correct won the Sahitya Akademi Award. His work frequently explores themes of addiction, urban life, and loss, drawing on his personal history and journalistic experience in cities like Mumbai and Hong Kong. Beyond literature, Thayil is a musician and editor, contributing significantly to contemporary Indian English writing.', '1762612531_jeet.webp', '2025-11-08 14:35:31', '2025-11-08 17:35:31'),
(19, 'Salman Rushdie', 'Sir Salman Rushdie is an eminent novelist known for blending magic realism with historical fiction, whose work, particularly The Satanic Verses, led to a fatwa calling for his assassination. In August 2022, he survived a brutal on-stage stabbing that left him blind in one eye and with nerve damage to one hand. Despite these life-altering injuries, Rushdie has demonstrated remarkable resilience, publishing the acclaimed memoir Knife: Meditations After an Attempted Murder in April 2024 and his first post-attack work of fiction, the short story collection The Eleventh Hour, in November 2025. His attacker was convicted and sentenced to 25 years in prison in May 2025, while Rushdie continues to be a powerful voice and symbol for freedom of expression and the enduring power of storytelling.', '1762612614_salman.webp', '2025-11-08 14:36:54', '2025-11-08 17:36:54'),
(20, 'Ruskin Bond', 'Ruskin Bond is an iconic Anglo-Indian author celebrated for his vast body of work that includes over 500 short stories, essays, and novels, with a particular focus on children\'s literature and stories set in the tranquil Himalayan foothills. Known for his simple yet profound storytelling style that captures the beauty of nature and human relationships, Bond has resided in Landour, Mussoorie, since 1963 and has won prestigious awards like the Padma Bhushan. His enduring legacy lies in his ability to connect with readers of all ages through poignant, \"slice-of-life\" narratives that often draw from his own life experiences in the hill stations of India.', '1762612662_ruskin.webp', '2025-11-08 14:37:42', '2025-11-08 17:37:42'),
(21, 'O. N. V. Kurup', 'O. N. V. Kurup was a celebrated Indian poet and lyricist in Malayalam literature, recognized as one of the preeminent literary figures of Kerala. He was awarded the Jnanpith Award in 2007 for his vast body of work, which blended simplicity with profound humanistic and social themes. Beyond poetry, he was an acclaimed lyricist for Malayalam cinema, winning numerous state and national awards. His contributions to both literature and culture cemented his legacy as a beloved and influential figure.', '1762612733_onv.webp', '2025-11-08 14:38:53', '2025-11-08 17:38:53'),
(22, 'Adoor Gopalakrishnan', 'Adoor Gopalakrishnan (born 3 July 1941) is an internationally renowned Indian film director, screenwriter, and producer credited with pioneering the \"New Wave\" in Malayalam cinema. Known for his minimalist yet profound style, his films delve into the intricate relationship between the individual and society in Kerala. Throughout his illustrious career, he has directed only 12 feature films, nearly all of which have won major national and international awards, including the Dadasaheb Phalke Award and the British Film Institute\'s Sutherland Trophy. He is a living legend who continues to be an influential figure in Indian art cinema.', '1762612785_adoor.webp', '2025-11-08 14:39:45', '2025-11-08 17:39:45'),
(23, 'Onjali Q. Raúf', 'Onjali Q. Raúf MBE is an award-winning British author and a human rights activist. She is best known for her children\'s books, which often explore social issues, and for her work as the founder of two non-profit organizations: Making Herstory and O\'s Refugee Aid Team. ', '1763208528_Onjali_Q._Raúf.webp', '2025-11-08 16:13:56', '2025-11-15 15:08:48'),
(25, 'Stephen', NULL, 'default-author.png', '2025-11-15 13:10:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `userid` int(11) NOT NULL,
  `bookid` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `cndtn` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `status` enum('Available','Sold') DEFAULT 'Available',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`userid`, `bookid`, `author_id`, `title`, `author`, `genre`, `description`, `cndtn`, `image`, `price`, `status`, `views`, `created_at`) VALUES
(1, 1, 1, 'hamlet', 'william shakespeare', 'Mystery', 'Shakespeare\'s longest and most celebrated tragedy, Hamlet, explores themes of revenge, madness, and moral corruption through the story of the Prince of Denmark. Written around 1600, the play is a revenge tragedy that culminates in a pile of bodies and the downfall of an entire royal family.', 'Very Good', '1758737445_32ce496c3be1d5d93a8e73bfda346112.jpg', '300', 'Sold', 38, '2025-09-24 18:10:45'),
(2, 2, 3, 'computer science education', '', 'Educational', 'Computer Science Education: Perspectives on Teaching and Learning in School is a book that brings together current research from experts around the world on the subject of computer science education. The book aims to bridge the gap between practical \"how-to\" guides for teachers and the body of research in the field.', 'Like New', '1762418229_cs.jpg', '300', 'Available', 5, '2025-11-06 08:37:09'),
(10, 9, 4, 'childhood', '', 'Novel', 'Childhood (1852) is the debut novel by Leo Tolstoy and the first part of his autobiographical trilogy. The story follows the young Nikolenka Irtenev as he reflects on his early life, exploring universal themes of loss of innocence, familial love, and the pain of growing up. The novel blends real details from Tolstoy\'s own life with fiction and was a critical success that established him as a prominent new Russian author.', 'Good', '1762613482_childhood.jpeg', '200', 'Available', 0, '2025-11-08 14:51:22'),
(10, 10, 5, 'The Murder of Roger Ackroyd', '', 'Mystery', 'The Murder of Roger Ackroyd is a seminal 1926 mystery novel by Agatha Christie, renowned for one of the most famous twist endings in the history of detective fiction. The story is narrated by the local doctor, James Sheppard, who assists Hercule Poirot in investigating the stabbing of wealthy industrialist Roger Ackroyd in the quiet village of King\'s Abbot. The novel cleverly subverts genre conventions when Poirot reveals the seemingly trustworthy narrator himself to be the murderer and blackmailer, who fabricated his account to hide the truth.', 'Acceptable', '1762613628_murder.jpeg', 'exchange', 'Available', 1, '2025-11-08 14:53:48'),
(10, 11, 6, 'Around the World in Eighty Days', '', 'Adventure', 'Around the World in Eighty Days is a renowned 1872 adventure novel by Jules Verne about the eccentric Englishman Phileas Fogg and his French valet, Passepartout, who attempt to circumnavigate the globe in just 80 days to win a substantial wager. Their journey, made possible by the rapid technological advancements of the Victorian era, is fraught with obstacles, including a persistent detective who mistakes Fogg for a bank robber, the rescue of an Indian princess named Aouda, and numerous missed connections. The novel culminates in a famous twist: Fogg succeeds in his seemingly impossible task by inadvertently gaining a day while traveling eastward across the International Date Line, highlighting themes of order versus chaos and the value of human connection over rigid routine.', 'Very Good', '1762613753_Around the World in 80 Days.jpeg', 'exchange', 'Available', 0, '2025-11-08 14:55:53'),
(10, 12, 7, 'Mansfield Park', '', 'Novel', 'Mansfield Park, published in 1814, is a novel by Jane Austen that tells the story of Fanny Price, a young woman sent to live with her wealthy relatives, the Bertram family. The narrative explores themes of morality, social class, and integrity as Fanny navigates the complex relationships within the estate, particularly her unrequited love for her cousin Edmund and the challenges posed by the charming but morally ambiguous Henry and Mary Crawford. The novel is known for its subtle critique of the slave trade, which funded the Bertrams\' lifestyle, and its diverse critical interpretations of Fanny\'s character, who ultimately chooses principle over convenience.', 'Like New', '1762613888_Mansfield Park.jpeg', '100', 'Available', 0, '2025-11-08 14:58:08'),
(10, 13, 8, 'Neelavelicham', '', 'Horror', '\"Neelavelicham\" is a celebrated romantic horror short story by the iconic Malayalam author Vaikom Muhammad Basheer. It describes the poignant relationship between a young writer who moves into a haunted house and the ghost of the former occupant, a young woman named Bhargavi who died tragically by suicide. The story achieved immense cultural significance through its adaptation into the landmark 1964 Malayalam horror film Bhargavi Nilayam, which was scripted by Basheer himself and became a classic of the genre, and was later remade in 2023 under the original title Neelavelicham.', 'Very Good', '1762614005_neela.jpeg', '200', 'Available', 0, '2025-11-08 15:00:05'),
(10, 14, 9, 'Randamoozham', '', 'Novel', 'Randamoozham is a seminal 1984 Malayalam novel by M. T. Vasudevan Nair that offers a powerful, humanistic reinterpretation of the Mahabharata through the eyes of Bhima, the second Pandava brother. It chronicles the epic\'s events from his perspective, highlighting his frustrations at being marginalized and overshadowed by his brothers despite his vital contributions. The narrative strips away divine intervention, portraying the characters as flawed humans and focusing on themes of loyalty, unrequited love, and the overlooked hero. A recipient of major literary awards including the Vayalar Award, the novel has been translated into English as Second Turn and Bhima: Lone Warrior, and is widely considered the author\'s masterpiece.', 'Like New', '1762614100_rand.jpeg', '300', 'Available', 0, '2025-11-08 15:01:40'),
(10, 15, 10, 'Pravasam', '', 'Novel', 'Pravasam (പ്രവാസം) is a significant Malayalam term meaning \"migration\" or \"exile,\" primarily used to describe the lives and experiences of non-resident Keralites, particularly those working in the Middle East. The theme encompasses the aspiration for better opportunities alongside the emotional challenges of living abroad, such as homesickness and navigating cultural identity. Pravasam is a major theme in Malayalam literature, with notable works like M. Mukundan\'s novel Pravasam and Benyamin\'s acclaimed Aadujeevitham exploring the complex realities of the migrant experience.', 'Acceptable', '1762614265_pravasam.jpeg', '120', 'Available', 0, '2025-11-08 15:04:25'),
(10, 16, 11, 'Qabar', '', 'Novel', '\r\nK. R. Meera\'s novella Qabar is a powerful story that weaves together magical realism, feminist themes, and contemporary Indian politics. The narrative centers on Bhavana, a district court judge and single mother, whose life is upended when she presides over a property dispute case involving a mysterious petitioner, Khayaluddin Thangal. ', 'New', '1762615398_Qabar.jpeg', '300', 'Available', 0, '2025-11-08 15:23:18'),
(10, 17, 12, 'Aadujeevitham', '', 'Novel', '\"Goat Days\" primarily refers to the critically acclaimed, best-selling Malayalam novel Aadujeevitham by Benyamin, which tells the harrowing true story of an Indian migrant sold into slavery as a goatherd in the Saudi Arabian desert. The novel explores themes of survival, hope, and the human spirit\'s resilience against extreme adversity, and it was adapted into the 2024 feature film The Goat Life. The term also encompasses various festivals and commemorative events, such as the International Goat Days Festival in Tennessee and \"World Goat Day\" on August 21, which celebrate the role of goats in agriculture and culture worldwide.', 'Like New', '1762615563_goatlife.jpeg', '260', 'Available', 0, '2025-11-08 15:26:03'),
(10, 18, 13, 'Ramanan', '', 'Poetry', 'Ramanan is a renowned book in Malayalam literature, authored by the influential poet Changampuzha Krishna Pillai and first published in 1936. It is a long narrative poem structured as a dramatic pastoral elegy, deeply infused with romanticism and sorrow. The story, which addresses the tragic love and life of the title character, was inspired by the real-life suicide of the author\'s close friend, Edappally Raghavan Pillai. The book gained immense popularity for its simple, musical language and emotional depth, becoming a bestseller and a significant milestone in modern Indian poetry.', 'Poor', '1762615711_ramanan.jpeg', 'exchange', 'Available', 0, '2025-11-08 15:28:31'),
(10, 19, 14, 'karuna', '', 'Poetry', 'make an short para\r\nKumaran Asan\'s Karuna (1923) is a celebrated narrative poem in Malayalam literature that explores themes of compassion, redemption, and the transient nature of worldly life through a Buddhist legend. It tells the story of Vasavadatta, a beautiful but later destitute courtesan, and the compassionate monk Upagupta. Asan uses the encounter between the two to illustrate the Buddhist ideal of karuna (compassion) triumphing over physical desire, ultimately leading to Vasavadatta\'s spiritual redemption and emphasizing that true beauty lies in inner peace rather than fleeting physical charm.', 'Poor', '1762615914_karuna.jpeg', 'exchange', 'Available', 0, '2025-11-08 15:31:54'),
(10, 20, 15, 'Sugathakumari', '', 'Poetry', 'Sugathakumari, a leading voice in Malayalam literature, authored numerous critically acclaimed books, primarily poetry collections that resonated deeply with readers for their emotional depth and strong advocacy for environmental conservation. Her notable works include the award-winning Rathrimazha (Night Rain), which secured the Kendra Sahitya Akademi Award, and Pathirappookkal (Midnight Flowers), for which she received the Kerala Sahitya Akademi Award. Beyond poetry, her legacy as a fierce eco-feminist and social activist is embedded in works like Kaadinu Kaaval (Guardians of the Forest), and selections of her writings have also been made available in English translations.', 'Very Good', '1762616040_rathri mazha.jpeg', '500', 'Available', 0, '2025-11-08 15:34:00'),
(10, 21, 16, 'azadi', '', 'Non-Fiction', 'Arundhati Roy\'s book Azadi is a collection of non-fiction political essays. In these writings, she explores the idea of freedom in a world that is becoming more and more controlled by authoritarian governments. The essays focus on current events and political issues in India, such as the situation in Kashmir and the rise of Hindu nationalism, using her strong opinions to critique social injustice and call for a better future.', 'New', '1762616509_asadi.jpeg', '500', 'Available', 0, '2025-11-08 15:41:49'),
(10, 22, 17, 'Mistress', '', 'Novel', 'Anita Nair is a celebrated Indian author whose 2005 novel Mistress received international acclaim for its complex exploration of human relationships and artistic expression. Set against the backdrop of Kerala\'s rich cultural landscape, the novel uses the nine emotional states (rasas) of the classical dance form Kathakali to structure a compelling narrative about marriage, infidelity, and the pursuit of artistic meaning. The book was longlisted for the Orange Prize and has been praised for its eloquent prose and deep insight into the intricacies of love and betrayal. Nair continues to be a prominent voice in Indian English literature, with other successful works including Ladies Coupé and the Inspector Gowda crime series.', 'Good', '1762616627_mistress.jpeg', '300', 'Available', 0, '2025-11-08 15:43:47'),
(10, 23, 18, 'Apocalypso', '', 'Poetry', 'Jeet Thayil\'s debut poetry collection, Apocalypso (1997), offers a raw and intense examination of the secular limits of love, heartbreak, and despair. Known for their song-like rhythms and biblical imagery, the poems reflect the author\'s background as a musician. This early work established the gritty, intimate style that would characterize much of Thayil\'s later writing, including his award-winning poetry and Booker Prize-shortlisted novel Narcopolis. A combined flipbook edition of Apocalypso and his subsequent collection English was released in 2023 by Penguin Random House India.', 'Very Good', '1762616776_apocalypso.jpeg', '200', 'Available', 0, '2025-11-08 15:46:16'),
(10, 24, 19, 'The Eleventh Hour', '', 'Fiction', 'The Eleventh Hour, a collection of five stories published in November 2025, marks Salman Rushdie\'s first fiction since his 2022 attack. Using his signature magical realism and wit, the book explores themes of aging, mortality, and artistic legacy, examining whether the \"eleventh hour\" of life should be met with serenity or rage, while also addressing threats to civilization.', 'Like New', '1762616912_11.jpeg', '260', 'Available', 0, '2025-11-08 15:48:32'),
(10, 25, 20, 'The Girl on the Train', '', 'Fantasy', 'Ruskin Bond\'s The Girl on the Train is an evocative collection of short stories centered on themes of longing, nostalgia, and the delicate nature of human connection. The title story is a poignant tale of a blind narrator and a girl he meets on a train journey; both characters, concealing their lack of sight, engage in a charming conversation built on pretense. The narrative culminates in a revelation that neither could see the other, creating a moment of powerful situational irony and capturing the quiet beauty and fleeting nature of encounters during travel. The collection beautifully showcases Bond\'s characteristic, gentle storytelling style, celebrating quiet moments and unspoken feelings.\r\n\r\n\r\n\r\n', 'Good', '1762617049_train.jpeg', '200', 'Available', 0, '2025-11-08 15:50:49'),
(10, 26, 21, 'End of the Day', '', 'Poetry', '\"End of the Day\" (Malayalam: \"Dinantam\") is an acclaimed, autobiographical long poem by the revered Malayalam poet O. N. V. Kurup. The work is a deeply humanistic reflection that weaves together personal nostalgia with universal themes: environmental urgent concerns (\"a scream for the dying earth\"), social empathy for the downtrodden, and philosophical musings on the cycle of life. Despite exploring painful memories and global failures, the poem ultimately delivers a powerful message of enduring hope and the profound, unbreakable bond between humanity and the earth.', 'Like New', '1762617178_end.jpeg', '400', 'Available', 8, '2025-11-08 15:52:58'),
(10, 27, 25, 'monologue', 'Stephen', 'Drama', 'Adoor Gopalakrishnan is a celebrated Indian filmmaker, not an actor who performs monologues; however, his 1987 film is famously titled Anantaram, which translates to \"Monologue\" in English. This film is structurally an extended first-person narrative where the protagonist, Ajayan, delivers a continuous voiceover recounting his life. The innovative \"monologue\" format allows Gopalakrishnan to explore the protagonist\'s unreliable memory and psychological state, presenting two conflicting versions of events to delve into themes of duality, mental health, and social alienation, a hallmark of his minimalist, introspective style of filmmaking.', 'Acceptable', '1762617395_monologue.jpeg', '102', 'Available', 24, '2025-11-08 15:56:35'),
(10, 28, 23, 'The Boy at the Back of the Class', '', 'Children', 'The Boy at the Back of the Class by Onjali Q. Raúf is a touching children’s story about friendship, kindness, and understanding. It follows a young Syrian refugee named **Ahmet**, who joins a new school in London after escaping war. Though he is shy and alone at first, his classmates — led by a kind and curious narrator — try to help him feel welcome. When they learn that Ahmet has been separated from his family, they come up with a brave plan to reunite him with them. The story beautifully shows how compassion and courage can make a real difference, even from the smallest hearts.\r\n', 'Good', '1762618436_The-Boy-at-the-Back-of-the-Class.jpg', '300', 'Available', 4, '2025-11-08 16:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `bookid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `userid`, `bookid`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sender_id`, `receiver_id`, `message`) VALUES
(1, 2, 1, 'hey there!!!'),
(2, 10, 1, 'hey there'),
(3, 1, 10, 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `seller_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 5, 'good', '2025-10-08 18:40:47'),
(2, 1, 10, 3, 'good', '2025-11-09 19:25:50'),
(3, 1, 10, 5, '', '2025-11-10 14:24:30'),
(4, 1, 10, 5, '', '2025-11-10 14:30:54'),
(5, 1, 10, 5, 'llllllllll', '2025-11-10 14:31:01'),
(6, 1, 10, 5, 'goood', '2025-11-10 14:32:14'),
(7, 1, 10, 4, 'coool', '2025-11-10 14:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `place_id` int(11) NOT NULL,
  `district_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`place_id`, `district_name`) VALUES
(1, 'Thiruvananthapuram'),
(2, 'Kollam'),
(3, 'Pathanamthitta'),
(4, 'Alappuzha'),
(5, 'Kottayam'),
(6, 'Idukki'),
(7, 'Ernakulam'),
(8, 'Thrissur'),
(9, 'Palakkad'),
(10, 'Malappuram'),
(11, 'Kozhikode'),
(12, 'Wayanad'),
(13, 'Kannur'),
(14, 'Kasaragod');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `seller_id`, `user_id`, `reason`, `details`, `created_at`) VALUES
(1, 1, 10, 'Other', 'bad experiance', '2025-11-10 14:37:19'),
(2, 1, 10, 'Other', 'bad experiance', '2025-11-10 14:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phno` varchar(15) DEFAULT NULL,
  `otp` varchar(6) NOT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `id_proof` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `city` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `phno`, `otp`, `razorpay_payment_id`, `id_proof`, `status`, `city`, `profile_pic`, `created_at`) VALUES
(1, 'crixus', 'crixus@gmail.com', 'crixus123', '2147483647', '', 'pay_RLWryndwv7N4vQ', '1758736659_ID-Proof.jpg', 'accepted', 'puthuppady', '1759319718_mann.jpeg', '2025-09-24 17:57:39'),
(2, 'farha', 'farha@gmail.com', 'farhafiroz', '2147483647', '', 'pay_RQG1P0TFeRPk0h', '1759769017_ID-Proof.jpg', 'accepted', 'Thrissur', 'default.png', '2025-10-06 16:43:37'),
(10, 'adhithyan', 'adhithyanvm85@gmail.com', 'jithu123', '8590999863', '', 'pay_RdHfuSk7L5xz5x', '1762613261_ID-Proof.jpg', 'accepted', 'Ernakulam', '1762764583_jules verne.jpeg', '2025-11-08 14:47:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `bookid` (`bookid`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feedback_seller` (`seller_id`),
  ADD KEY `fk_feedback_user` (`user_id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reports_seller` (`seller_id`),
  ADD KEY `fk_reports_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`bookid`) REFERENCES `books` (`bookid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_seller` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_seller` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reports_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
