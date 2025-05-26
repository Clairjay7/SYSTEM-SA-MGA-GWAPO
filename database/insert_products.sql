USE GALORPOT;

-- Clear existing products
TRUNCATE TABLE inventory;

-- Insert Hot Wheels products
INSERT INTO inventory (product_name, description, price, quantity, image_url, category) VALUES
('Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 'Limited Edition 25th Anniversary Lamborghini Countach', 100.75, 10, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp', 'Hot Wheels'),
('Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 'Classic Ferrari F355 Berlinetta in Red', 1000.75, 5, 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp', 'Hot Wheels'),
('Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars', 'Virtual Collection Lamborghini Diablo', 555.75, 8, 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp', 'Hot Wheels'),
('Hot Wheels 1995 Nissan Skyline GT-R', 'Classic Japanese Sports Car', 250.50, 15, 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp', 'Hot Wheels'),
('Hot Wheels 2020 Ford Mustang GT', 'Modern American Muscle Car', 450.99, 12, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp', 'Hot Wheels'),
('Hot Wheels Batmobile', 'Iconic Batman Vehicle', 300.00, 20, 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp', 'Hot Wheels'),
('Hot Wheels McLaren P1', 'British Supercar', 650.00, 7, 'https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Porsche 911 Turbo', 'German Sports Car Classic', 380.75, 9, 'https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Toyota Supra A80', 'Japanese Sports Car Legend', 420.25, 11, 'https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels 1994 Mazda RX-7', 'Rotary Engine Sports Car', 550.00, 6, 'https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Dodge Viper GTS', 'American Supercar', 700.50, 4, 'https://i.ebayimg.com/images/g/eeIAAeSwyvBn8McZ/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels 1969 Camaro Z28', 'Classic American Muscle', 320.00, 14, 'https://i.ebayimg.com/images/g/H3EAAOSwjYVmoeH1/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Ferrari 512 TR', 'Italian Supercar', 850.75, 3, 'https://i.ebayimg.com/images/g/-9YAAOSwF61mS5C7/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Pagani Huayra', 'Italian Hypercar', 950.99, 2, 'https://i.ebayimg.com/images/g/EL8AAeSw8gxn07r7/s-l960.webp', 'Hot Wheels'),
('Hot Wheels Chevrolet Corvette ZR1', 'American Sports Car', 760.00, 8, 'https://i.ebayimg.com/images/g/XWUAAOSwOVRnozkp/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Aston Martin DB11', 'British Grand Tourer', 600.25, 7, 'https://i.ebayimg.com/images/g/BoYAAeSwegVn68LO/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Shelby GT500 Mustang', 'High-Performance Mustang', 670.00, 6, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Dodge Charger RT', 'Classic American Muscle', 440.99, 10, 'https://i.ebayimg.com/images/g/XQ8AAOSw~oJnerHf/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels BMW M3 E30', 'German Performance Classic', 500.00, 9, 'https://i.ebayimg.com/images/g/KOQAAOSwea5nxcJz/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Subaru Impreza WRX STI', 'Japanese Rally Car', 580.00, 8, 'https://i.ebayimg.com/images/g/N4cAAOSwKj5ncIoe/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Ferrari 488 GTB', 'Modern Ferrari Supercar', 700.99, 5, 'https://i.ebayimg.com/images/g/BfMAAOSwMKdko7BH/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Bugatti Chiron', 'Ultimate Hypercar', 1200.00, 2, 'https://i.ebayimg.com/images/g/VfcAAOSwfDVn1BD4/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Audi R8 V10', 'German Supercar', 800.00, 4, 'https://i.ebayimg.com/images/g/ScgAAOSwR7Blaecl/s-l1600.webp', 'Hot Wheels'),
('Hot Wheels Lamborghini Huracan', 'Italian Supercar', 900.00, 3, 'https://i.ebayimg.com/images/g/vw8AAOSwshhnchkQ/s-l1600.webp', 'Hot Wheels'); 