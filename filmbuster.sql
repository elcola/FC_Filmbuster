-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Lug 09, 2013 alle 06:45
-- Versione del server: 5.5.20
-- Versione PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filmbuster`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `anno`
--

CREATE TABLE IF NOT EXISTS `anno` (
  `anno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `anno`
--

INSERT INTO `anno` (`anno`) VALUES
(2000),
(2001),
(2002),
(2003),
(2004),
(2005),
(2006),
(2007),
(2008),
(2009),
(2010),
(2011),
(2012),
(2013);

-- --------------------------------------------------------

--
-- Struttura della tabella `gruppo`
--

CREATE TABLE IF NOT EXISTS `gruppo` (
  `id_gruppo` int(16) NOT NULL,
  `nome_gruppo` varchar(16) NOT NULL,
  PRIMARY KEY (`id_gruppo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `gruppo`
--

INSERT INTO `gruppo` (`id_gruppo`, `nome_gruppo`) VALUES
(1, 'cliente'),
(2, 'amministratore');

-- --------------------------------------------------------

--
-- Struttura della tabella `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `nome` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `menu`
--

INSERT INTO `menu` (`nome`) VALUES
('home'),
('categorie'),
('anno'),
('a-z'),
('cerca'),
('contatti');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE IF NOT EXISTS `prodotti` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(250) NOT NULL,
  `immagine` varchar(250) NOT NULL,
  `prezzo` decimal(11,2) NOT NULL,
  `rank` int(4) NOT NULL DEFAULT '0',
  `anno` int(4) NOT NULL,
  `nazione` varchar(50) NOT NULL,
  `durata` int(4) NOT NULL,
  `genere` varchar(50) NOT NULL,
  `regia` varchar(50) NOT NULL,
  `trama` longtext NOT NULL,
  `attori` varchar(250) NOT NULL,
  `quantita` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id`, `titolo`, `immagine`, `prezzo`, `rank`, `anno`, `nazione`, `durata`, `genere`, `regia`, `trama`, `attori`, `quantita`) VALUES
(1, 'Anna Karenina ', 'anna_karenina.jpg', '25.00', 0, 2000, 'ITALIA', 148, 'avventura', 'Joe Wright ', 'Adattametnto della celebre opera di Tolstoj dal regista di Orgoglio e pregiudizio.', 'Keira Knightley, Jude Law, Matthew Macfadyen, Aaron Johnson, Emily Watson ', 25),
(2, 'Anime nella nebbia - V Tumane ', 'anime_nella_nebbia_-_v_tumane.jpg', '46.00', 0, 2011, 'USA', 160, 'thriller', 'Sergei Loznitsa ', 'Seconda guerra mondiale, in una foresta due partigiani si confrontano, uno dei due è accusato di aver collaborato con il nemico.', 'Vladimir Svirski, Vlad Abashin, Sergea`¯ Kolesov ', 27),
(3, 'A Royal Weekend ', 'a_royal_weekend.jpg', '100.00', 0, 2010, 'FRANCIA', 172, 'thriller', 'Roger Michell ', 'Giugno 1939 il Presidente Franklin Delano Roosevelt e sua moglie Eleanor ospitano il re e la regina di Inghilterra per un weekend nella loro casa di Hyde Park on Hudson.', 'Bill Murray, Laura Linney, Olivia Williams, Olivia Colman ', 29),
(4, 'Asterix e Obelix al servizio di sua maesta', 'asterix_e_obelix_al_servizio_di_sua_maesta.jpg', '115.00', 0, 2001, 'ITALIA', 184, 'commedia', 'Laurent Tirard ', 'Trasferta britannica per la celebre coppia di Galli che stavolta accorre in soccorso della Regina Cordelia minacciata dalla megalomania del solito Cesare.', 'Gerard Depardieu, Edouard Baer, Fabrice Luchini, Catherine Deneuve, Filippo Timi, Neri Marcorè ', 31),
(5, 'Attacco al potere - Olympus Has Fallen ', 'attacco_al_potere_-_olympus_has_fallen.jpg', '25.00', 0, 2012, 'USA', 122, 'azione', 'Antoine Fuqua ', 'Un ex-agente dei Servizi segreti si trasforma nell`ultima speranza della nazione quando la Casa Bianca viene espugnata da alcuni terroristi.', 'Gerard Butler, Aaron Eckhart, Melissa Leo, Ashley Judd ', 33),
(6, 'Le avventure di Fiocco di neve ', 'le_avventure_di_fiocco_di_neve.jpg', '46.00', 0, 2002, 'FRANCIA', 130, 'commedia', 'Andras G. Schaer ', 'Un cucciolo rarissimo di gorilla bianco approda allo zoo di Barcellona e diventa una grande attrazione, ma i suoi simili non lo accettano e lo isolano.', 'Elsa Pataky, Pere Ponce, Claudia Abate, Juan Sulla`  ', 35),
(7, 'Gli amanti passeggeri ', 'gli_amanti_passeggeri.jpg', '100.00', 0, 2003, 'ITALIA', 138, 'commedia', 'Pedro Almodovar ', 'Un gruppo di viaggiatori si ritrova alle rpese con situazione di pericolo a bordo di un aereo diretto a Citta`  del Messico, ognuno l`affrontera`  a modo proprio.', 'Penelope Cruz, Antonio Banderas, Paz Vega, Blanca Sua`¡rez ', 37),
(8, 'After Earth - Dopo la fine del mondo ', 'after_earth_-_dopo_la_fine_del_mondo.jpg', '115.00', 0, 2004, 'USA', 146, 'fantascienza', 'M. Night Shyamalan ', 'Mille anni dopo che eventi catastrofici hanno costretto l`umanita`  ad abbandonare la Terra, Cypher Raige e Kitai, padre e figlio, a bordo di una navicella precipitano su un pianeta divenuto ostile e pericoloso. Con il padre ferito tocchera`  a Kitai partire in cerca di aiuto.', 'Will Smith, Jaden Smith, Isabelle Fuhrman ', 39),
(9, 'Battle of the Year: La vittoria e` in ballo di Benson Lee ', 'battle_of_the_year_la_vittoria_e_in_ballo_di_benson_lee.jpg', '12.00', 0, 2009, 'ITALIA', 154, 'commedia', 'Antoine Fuqua', 'Una crew di ballerini e il loro allenatore dopo molte delusioni affrontano il pia`¹ grande campionato di break-dance.', 'Josh Holloway, Josh Peck, Chris Brown ', 41),
(10, 'Beautiful Creatures - La sedicesima luna di Richard LaGravenese-', 'beautiful_creatures_-_la_sedicesima_luna_di_richard_lagravenese.jpg', '115.00', 0, 2005, 'ITALIA', 162, 'thriller', 'Richard LaGravenese', 'Ethan e Lena scoprono di avere una connessione sovrannaturale legata al passato della citta`  in cui vivono e delle loro famiglie che nascondono segreti inimmaginabili.', 'Alice Englert, Alden Ehrenreich, Emma Thompson, Viola Davis, Jeremy Irons', 43),
(11, 'The Big Wedding ', 'the_big_wedding.jpg', '25.00', 0, 2006, 'USA', 170, 'commedia', 'Justin Zackham ', 'Don e Ellie Griffin, una coppia da tempo divorziata e in perenne conflitto, saranno costretti ad interpretare la parte di una coppia felice per il bene del matrimonio del loro figlio adottivo,', 'Robert De Niro, Diane Keaton, Amanda Seyfried, Robin Williams, Katherine Heigl, Susan Sarandon, Topher Grace ', 45),
(12, 'Broken City ', 'broken_city.jpg', '46.00', 0, 2012, 'FRANCIA', 178, 'thriller', 'Allen Hughes con Mark Wahlberg, Russell Crowe, Cat', 'Un ex-poliziotto ora detective privato indaga per conto di una potente figura politica sull`amante della moglie di quest`ultimo, ne seguira`  un omicidio che inneschera`  indagini nell`ambiguo mondo della politica.', '', 26),
(13, 'Burt Wonderstone ', 'burt_wonderstone.jpg', '100.00', 0, 2012, 'ITALIA', 112, 'commedia', 'Don Scarno ', 'Due illusionisti di Las Vegas a seguito di un incidente si separano, ma torneranno a far squadra quando un terzo mago carismatico e alla moda comincera`  a metterli in ombra.', 'Steve Carell, Jim Carrey, Olivia Wilde, Steve Buscemi, James Gandolfini, Alan Arkin ', 29),
(14, 'Buon Anno Sarajevo ', 'buon_anno_sarajevo.jpg', '115.00', 0, 2007, 'USA', 120, 'avventura', 'Aida Begic ', 'Rahima e Nedim sono due fratelli che vivono a Sarajevo, un incidente a scuola che coinvolgera`  Nadim portera`  Rahima a scoprire che il fratello conduce una doppia vita.', 'Marija Pikic, Ismir Gagula ', 32),
(15, 'La casa - Evil Dead ', 'la_casa_-_evil_dead.jpg', '12.00', 0, 2010, 'ITALIA', 128, 'horror', 'Fede Alvarez ', 'Remake del classico horror anni â€˜80 di Sam Raimi qui in veste di produttore. Un gruppo di ragazzi si reca in un cottage isolato nei boschi dove risveglia un`antica e inarrestabile forza demoniaca.', 'Jane Levy, Jessica Lucas, Shiloh Fernandez, Lou Taylor Pucci, Elizabeth Blackmore ', 35),
(16, 'Cercasi amore per la fine del mondo ', 'cercasi_amore_per_la_fine_del_mondo.jpg', '25.00', 0, 2010, 'USA', 136, 'commedia', 'Lorene Scafaria ', 'Dodge e Penny intraprendono un ultimo viaggio in macchina mentre la Terra sta per essere colpita da un asteroide che cancellera`  l`umanita` ', 'Steve Carell, Keira Knightley, Adam Brody, Martin Sheen, William Petersen ', 38),
(17, 'Carrie ', 'carrie.jpg', '46.00', 0, 2000, 'FRANCIA', 144, 'horror', 'Kimberly Peirce ', 'Remake del classico anni ''70 di Brian De Palma basato su un romanzo di Stephen King. Carrie è una ragazza timida e impacciata che viene emarginata e vessata dai suoi compagni di scuola e tormentata dalla madre oppressiva, ma la scoperta di possedere poteri telecinetici scatenera`  una sanguinosa vendetta.', 'Chloè Moretz, Julianne Moore, Alex Russell, Gabriella Wilde ', 41),
(18, 'Cattivissimo me 2 ', 'cattivissimo_me_2.jpg', '100.00', 0, 2012, 'ITALIA', 152, 'animazione', 'Pierre Coffin e Chris Renaud ', 'Tornano in una nuova avventura ricca di azione, risate e gadget il cattivo dal cuore d`oro Gru, le sue tre bambine e gli spassosi minion.', 'Al Pacino, Jason Segel, Steve Carell ', 44),
(19, 'The Conjuring ', 'the_conjuring.jpg', '115.00', 0, 2011, 'USA', 160, 'thriller', 'James Wan ', 'Ispirato ad eventi reali il film racconta di come Ed e Lorraine Warren, investigatoiri esperti in sovrannnaturale, aiuteranno una famiglia a liberare la loro casa da una presenza maligna.', 'Vera Farmiga, Patrick Wilson, Mackenzie Foy, Ron Livingston, Lili Taylor ', 47),
(20, 'Cloud Atlas ', 'cloud_atlas.jpg', '12.00', 0, 2012, 'FRANCIA', 150, 'avventura', 'Tom Tykwer, Andy Wachowski, Lana Wachowski ', 'Il film racconta una serie di storie interconnesse tra di loro che tra passato, presente e futuro influenzeranno le vite e i destini dei diversi protagonisti.', 'Tom Hanks, Hugo Weaving, Ben Whishaw, Halle Berry, Jim Sturgess, Susan Sarandon, Hugh Grant ', 50),
(21, 'Captive ', 'captive.jpg', '25.00', 0, 2011, 'ITALIA', 160, 'avventura', 'Brillante Mendoza ', 'L`odissea di alcuni turisti stranieri che nelle Filippine vengono rapiti da un gruppo di separatisti islamici (Abu Sayyaf),', 'Isabelle Huppert, Kathy Mulville, Marc Zanetta, Rustica Carpio, Ronnie Lazaro ', 53),
(22, 'Il cacciatore di giganti ', 'il_cacciatore_di_giganti.jpg', '46.00', 0, 2010, 'USA', 170, 'azione', 'Bryan Singer ', 'Una bellicosa razza di giganti dichiara guerra agli umani per riconquistare i territori un tempo perduti. Jack, un giovane ragazzo, lottera`  per fermarli e per salvare una principessa rapita.', 'Ewan McGregor, Nicholas Hoult, Stanley Tucci, Bill Nighy, Ian McShane ', 56),
(23, 'I Croods ', 'i_croods.jpg', '100.00', 0, 2000, 'FRANCIA', 180, 'animazione', 'Kirk De Micco e Chris Sanders ', 'Una famiglia di cavernicoli in viaggio per cercare una nuova casa, incontrera`  lungo la strada un giovane ragazzo il cui pensiero ribelle e anticonformista si scontrera`  con quello fortemente tradizionale del capofamiglia.', 'Nicolas Cage, Ryan Reynolds, Emma Stone ', 59),
(24, 'Comic Movie - Movie 43 ', 'comic_movie_-_movie_43.jpg', '115.00', 0, 2012, 'ITALIA', 190, 'commedia', 'Elizabeth Banks, Steven Brill, Steve Carr, Rusty C', 'Un cast stellare per questa folle e dissacrante comedy a episodi nata dalla mente dei fratelli Farrelly (Tutti pazzi per Mary).', 'Emma Stone, Elizabeth Banks, Gerard Butler, Hugh Jackman, Chloa`« Grace Moretz, Anna Faris, Kate Winslet, Kristen Bell, Josh Duhamel, Kate Bosworth, Naomi Watts, Richard Gere, Justin Long, Jason Sudeikis, Uma Thurman, Seann William Scott, Kieran Culk', 12),
(25, 'Cobu 3D ', 'cobu_3d.jpg', '12.00', 0, 2011, 'USA', 200, 'commedia', 'Duane Adler ', 'Romeo e Giulietta in salsa dance. Nei sobborghi di New York due ballerini che appartengono a club di danza rivali si innamorano creando un inevitabile conflitto.', 'Derek Hough, Boa Kwon ', 17),
(26, 'Django Unchained ', 'django_unchained.jpg', '46.00', 0, 2010, 'FRANCIA', 145, 'western', 'Quentin Tarantino ', 'Lo schiavo liberato Django addestrato dal cacciatore di taglie Schultz cerca vendetta e intraprende un viaggio per trovare e liberare la moglie Broomhilda.', 'Jamie Foxx, Leonardo Di Caprio, Christoph Waltz, Samuel L. Jackson, Kurt Russell, Jonah Hill, Kerry Washington, Tom Savini, Don Johnson ', 22),
(27, 'Dead Man Down ', 'dead_man_down.jpg', '25.00', 0, 2000, 'ITALIA', 150, 'thriller', 'Niels Arden Oplev ', 'Victor è il braccio destro di un boss del crimine che ha causato la morte di sua moglie e di sua figlia. L`uomo in cerca di vendetta trovera`  sulla sua strada la tormentata Beatrice, anche lei con un conto da saldare con il boss sedurra`  e ricattera`  Victor costringendolo ad aiutarla.', 'Noomi Rapace, Colin Farrell, Dominic Cooper, Terrence Howard, Armand Assante, Isabelle Huppert ', 27),
(28, 'Die Hard - Un buon giorno per morire ', 'die_hard_-_un_buon_giorno_per_morire.jpg', '46.00', 0, 2012, 'USA', 155, 'azione', 'John Moore ', 'Torna Bruce Willis nei panni del superpoliziotto John McClane, in questo quinto capitolo McClane è in trasferta in Russia per aiutare il figlio ribelle Jack, inconsapevole che questi è in realta`  un agente operativo della CIA che sta cercando di sventare una rapina che vede come obiettivo delle armi nucleari.', 'Bruce Willis, Jai Courtney, Cole Hauser, Sebastian Koch, Mary Elizabeth Winstead ', 32),
(29, 'Elysium ', 'elysium.jpg', '100.00', 0, 2012, 'FRANCIA', 160, 'fantascienza', 'Neill Blomkamp ', 'Nell`anno 2159 le persone molto ricche vivono in un ambiente incontaminato ricreato dall`uomo su una stazione spaziale chiamata Elysium e il resto della popolazione è invece costretta su una Terra sovrappopolata e in rovina. Quando Max (Matt Damon) decidera`  di raggiungere Elysium si imbarchera`  in una missione disperata che in caso di successo non solo salvera`  la sua vita, ma potrebbe portare la parita`  in questi mondi agli antipodi.', 'Matt Damon, Jodie Foster, William Fichtner, Alice Braga, Sharlto Copley, Diego Luna ', 37),
(30, 'Ender`s Game ', 'ender`s_game.jpg', '115.00', 0, 2012, 'ITALIA', 165, 'fantascienza', 'Gavin HoodAsa Butterfield ', 'In un futuro prossimo una bellicosa razza aliena attacca la Terra, per questo il Colonnello Graff recluta per la sua Scuola di Guerra i pia`¹ promettenti ragazzi del pianeta. Tra questi c`è il timido Ender Wiggin, un ragazzo che dimostrera`  doti inaspettate.', 'Harrison Ford, Ben Kingsley, Viola Davis, Moises Arias, Abigail Breslin, Hailee Steinfeld ', 42),
(31, 'Epic - Il mondo segreto di Moonhaven ', 'epic_-_il_mondo_segreto_di_moonhaven.jpg', '25.00', 0, 2011, 'USA', 170, 'animazione', 'Chris Wedge ', 'Quando una ragazza adolescente si ritrova magicamente trasportata in un universo segreto, dovra`  unirsi ad una squadra di personaggi divertenti e stravaganti al fine di salvare il loro mondoâ€¦e il nostro.', '', 47),
(32, 'Flight ', 'flight.jpg', '46.00', 0, 2012, 'FRANCIA', 175, 'thriller', 'Robert Zemeckis ', 'Un esperto pilota di linea evita una catastrofe ad alta quota riuscendo a far atterrare il suo aereo, salvando cosa`¬ le vite di quasi tutti i passeggeri a bordo. Mentre media e opinione pubblica lo eleggono ad eroe una commissione d`inchiesta porta alla luce troppe domande senza risposta che incombono sull`accaduto.', 'Denzel Washington, James Badge Dale, John Goodman, Don Cheadle, Melissa Leo ', 52),
(33, 'Frankenweenie ', 'frankenweenie.jpg', '100.00', 0, 2011, 'ITALIA', 180, 'horror', 'Tim Burton ', 'Victor è un ragazzino che perde il suo amato cagnolino Sparky investito da un`automobile. Disperato per la perdita Il ragazzino ricorrera`  alla sua passione per la scienza per riportarlo in vita.', 'Winona Ryder, Catherine O`Hara, Martin Short, Martin Landau ', 57),
(34, 'Fast & Furious 6 ', 'fast_&_furious_6.jpg', '115.00', 0, 2010, 'USA', 90, 'azione', 'Justin Lin ', 'Dominc Toretto e la sua squadra si recano in Europa per un colpo che pera`² ha attirato l`attenzione di un altro team di rapinatori, saranno scintille.', 'Vin Diesel, Paul Walker, Dwayne Johnson, Michelle Rodriguez, Jordana Brewster, Tyrese Gibson ', 62),
(35, 'Frozen ', 'frozen.jpg', '12.00', 0, 2000, 'FRANCIA', 100, 'animazione', 'Chris Buck e Jennifer Lee ', 'Quando una profezia intrappola un intero regno in un inverno senza fine, Anna, una temeraria sognatrice, insieme al coraggioso uomo di montagna Kristoff e alla sua renna Sven, intraprende un viaggio epico alla ricerca della sorella Elsa, la Regina delle Nevi, per riuscire a porre fine al glaciale incantesimo.', 'Kristen Bell, Idina Menzel ', 67),
(36, 'Gambit ', 'gambit.jpg', '25.00', 0, 2011, 'ITALIA', 110, 'commedia', 'Michael Hoffman ', 'Un curatore dâ€?arte britannico (Firth) escogita una truffa per ingannare un ricco collezionista d`arte spingendolo all`acquisto un falso dipinto di Monet, ad aiutarlo una bella campionessa di rodeo texana (Diaz).', 'Colin Firth, Cameron Diaz, Stanley Tucci, Alan Rickman ', 20),
(37, 'G.I. Joe - La vendetta ', 'g.i._joe_-_la_vendetta.jpg', '46.00', 0, 2010, 'USA', 120, 'azione', 'Jon Chu ', 'In questo sequel in 3D i G.I. Joe non solo combattono contro i loro nemici mortali Cobra, ma sono costretti contrastare una minaccia proveniente dall`interno del governo che mette in pericolo la loro esistenza.', 'Channing Tatum, Bruce Willis, Dwayne Johnson, Ray Stevenson, Adrianne Palicki, Ray Park ', 22),
(38, 'Gangster Squad ', 'gangster_squad.jpg', '100.00', 0, 2000, 'FRANCIA', 130, 'azione', 'Ruben Fleischer ', 'Los Angeles anni â€˜40, il dipartimento di polizia crea una speciale task-force per contrastare lo strapotere del boss Mickey Cohen.', 'Ryan Gosling, Emma Stone, Sean Penn, Josh Brolin, Anthony Mackie, Nick Nolte ', 24),
(39, 'Ghost Movie ', 'ghost_movie.jpg', '115.00', 0, 2012, 'ITALIA', 85, 'commedia', 'Michael Tiddes ', 'Quando Malcolm e Kisha si trasferiscono nella loro casa dei sogni, scoprono di non essere soli. La casa è infestata e Kisha viene posseduta da uno spirito. Malcom dovra`  farsi aiutare da un prete e da alcuni acchiappafantasmi per sbarazzarsi del demone e salvare la sua vita matrimoniale e non soloâ€¦', 'Marlon Wayans, Essence Atkins, David Koechner, Cedric The Entertainer ', 26),
(40, 'The Ghostmaker ', 'the_ghostmaker.jpg', '12.00', 0, 2012, 'USA', 90, 'horror', 'Mauro Borrelli ', 'Un gruppo di studenti utilizza una misteriosa bara per riuscire ad oltrepassare i confini della morte, le conseguenze saranno devsatanti.', 'Aaron Dean Eisenberg, Liz Fenning ', 28),
(41, 'Il grande e potente Oz ', 'il_grande_e_potente_oz.jpg', '25.00', 0, 2011, 'FRANCIA', 95, 'fantascienza', 'Sam Raimi ', 'Oscar Diggs (James Franco) illusionista dalla discutibile etica impiegato in un piccolo circo viene trasportato dal Kansas nel fantastico Regno di Oz, qui dopo aver assaporato fama e fortuna dovra`  vederesela con tre streghe ben poco convinte che lui sia il grande mago che afferma di essere.', 'James Franco, Michelle Williams, Mila Kunis, Rachel Weisz ', 30),
(42, 'Il grande Gatsby ', 'il_grande_gatsby.jpg', '46.00', 0, 2010, 'ITALIA', 100, 'avventura', 'Baz Luhrmann ', 'Nuovo adattamento in 3D del classico letterario di F. Scott Fitzgerald che racconta la storia di un aspirante scrittore, Nick Carraway che lasciato il Midwest Americano, arriva a New York nella primavera del 1922 in cerca del suo personale Sogno Americano.', 'Leonardo Di Caprio, Carey Mulligan, Tobey Maguire, Isla Fisher, Joel Edgerton ', 32),
(43, 'Gravity ', 'gravity.jpg', '100.00', 0, 2000, 'USA', 105, 'thriller', 'Alfonso Cuaran ', 'Due astronauti in missione tentano un disperato ritorno verso la Terra, dopo che il loro shuttle è entrato in collisione con un meteorite.', 'George Clooney, Sandra Bullock ', 34),
(44, 'Hitchcock ', 'hitchcock.jpg', '25.00', 0, 2012, 'FRANCIA', 110, 'thriller', 'Sacha Gervasi ', 'Genesi e produzione del thriller Psycho, capolavoro indiscusso del maestro del brivido Alfred Hitchcok.', 'Anthony Hopkins, Scarlett Johansson, Jessica Biel, Helen Mirren, Ralph Macchio, Toni Collette ', 36),
(45, 'House at the End of the Street ', 'house_at_the_end_of_the_street.jpg', '46.00', 0, 2012, 'ITALIA', 70, 'horror', 'Mark Tonderai ', 'Madre e figlia si trasferiscono nei pressi di una casa che fu teatro di un massacro. Nell`abitazione vive l`unico superstite della strage, il ragazzo emarginato dalla comunita`  attirera`  l`attenzione della sua graziosa vicina di casa che s`infatuera`  di lui.', 'Jennifer Lawrence, Elisabeth Shue, Max Thieriot ', 38),
(46, 'Hunger Games: La ragazza di fuoco ', 'hunger_games_la_ragazza_di_fuoco.jpg', '100.00', 0, 2012, 'USA', 80, 'azione', 'Francis Lawrence con Jennifer Lawrence, Josh Hutch', 'Secondo capitolo della trilogia basata sui romanzi di Suzanne Collins. Katniss torna a casa con l`amico Peeta dopo aver vinto la 74Âª edizione degli Hunger Games. Impegnata in un tour nei vari distretti tocchera`  con mano la ribellione che sta montando di cui lei è il cuore pulsante. ma a Capitol city il Presidente Snow trama per mantenere il controllo e organizza un nuovo speciale torneo.', '', 40),
(47, 'Hansel & Gretel - Cacciatori di streghe ', 'hansel_&_gretel_-_cacciatori_di_streghe.jpg', '115.00', 0, 2011, 'FRANCIA', 90, 'commedia', 'Tommy Wirkola ', 'I fratelli Hansel e Gretel dopo le vicende narrate nella celebre fiaba dei fratelli Grimm sono ormai adulti e hanno messo a frutto la loro traumatica esperienza per diventare degli abili ammazzastreghe e non solo.', 'Jeremy Renner, Gemma Arterton, Famke Janssen, Peter Stormare, Zoe Bell ', 42),
(48, 'The Heat ', 'the_heat.jpg', '25.00', 0, 2010, 'ITALIA', 100, 'commedia', 'Paul Feig ', 'Un`agente dell`FBI arrogante e scrupolosa si trova costretta a far squadra con una sboccata poliziotta di Boston dai metodi ben poco convenzionali per riuscire ad incastrare un grosso trafficante di droga,', 'Sandra Bullock, Melissa McCarthy, Kaitlin Olson, Michael Rapaport ', 44),
(49, 'The Host ', 'the_host.jpg', '46.00', 0, 2001, 'USA', 110, 'fantascienza', 'Andrew Niccol ', 'Basato sull`omonimo romanzo di Stephenie Meyer (Twilight). Dopo una devastante invasione aliena da parte di esseri incorporei denominati Anime, alcune frange di resistenti cercano di sopravvivere alll`occupazione, tra loro c`è Melanie Stryder che pera`² viene catturata e la sua mente posseduta da un alieno noto come Wanderer.', 'Saoirse Ronan, Diane Kruger, Max Irons, Jake Abel, William Hurt ', 46);

-- --------------------------------------------------------

--
-- Struttura della tabella `submenu`
--

CREATE TABLE IF NOT EXISTS `submenu` (
  `nome` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `submenu`
--

INSERT INTO `submenu` (`nome`) VALUES
('Animazione'),
('Avventura'),
('Azione'),
('Classici'),
('Comici'),
('Commedia'),
('Erotici'),
('Fantascienza'),
('Guerra'),
('Horror'),
('Thriller'),
('Western');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `via` varchar(50) NOT NULL,
  `citta` varchar(20) NOT NULL,
  `provincia` varchar(2) NOT NULL,
  `cap` int(5) NOT NULL,
  `paese` varchar(20) NOT NULL,
  `telefono` varchar(11) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `data_nasc` date DEFAULT NULL,
  `pass` varchar(15) NOT NULL,
  `id_gruppo` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`nome`, `cognome`, `via`, `citta`, `provincia`, `cap`, `paese`, `telefono`, `email`, `data_nasc`, `pass`, `id_gruppo`) VALUES
('dsada', 'asdas', 'sada', 'asda', 'As', 0, 'Italia', '', '2222@h.it', '0000-00-00', '2222', 1),
('Daniele', 'Ragnoli', 'ss150', 'Roseto', 'TE', 64028, 'Italia', '6549961160', 'daniele@gmail.com', '1987-06-02', 'daniele', 1),
('Guerino', 'Angelozzi', 'nazionale', 'Roseto', 'TE', 64024, 'Italia', '3401245890', 'guerino@gmail.com', '1989-05-08', 'guerino', 2),
('Luca', 'Pierabella', 'della resistenza', 'Morro d''Oro', 'TE', 64020, 'Italia', '3406472279', 'luca@gmail.com', '1989-08-03', 'luca', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
