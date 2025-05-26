USE GALORPOT;

-- Clear existing inventory
TRUNCATE TABLE inventory;

-- Insert Hot Wheels products
INSERT INTO inventory (name, description, price, quantity, image_url) VALUES
('Hot Wheels 1997 FE Lamborghini Countach Yellow', 'A rare Lamborghini Countach model from 1997.', 100.75, 10, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp'),
('Hot Wheels 1999 Ferrari F355 Berlinetta Red', 'A highly detailed Ferrari model from 1999.', 1000.75, 5, 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp'),
('Hot Wheels 2000 Lamborghini Diablo Blue', 'A collectible Lamborghini Diablo model from 2000.', 555.75, 8, 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp'),
('Hot Wheels 1995 Nissan Skyline GT-R', 'A stunning Nissan Skyline GT-R model from 1995.', 250.50, 15, 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp'),
('Hot Wheels 2020 Ford Mustang GT', 'A sleek Ford Mustang GT model from 2020.', 450.99, 12, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp'),
('Hot Wheels Batmobile', 'The iconic Batmobile model.', 300.00, 20, 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp'),
('Hot Wheels McLaren P1', 'A limited edition McLaren P1 model.', 650.00, 7, 'https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp'),
('Hot Wheels Porsche 911 Turbo', 'A detailed Porsche 911 Turbo model.', 380.75, 9, 'https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp'),
('Hot Wheels Toyota Supra A80', 'A collectible Toyota Supra A80 model.', 420.25, 11, 'https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp'),
('Hot Wheels 1994 Mazda RX-7', 'A rare Mazda RX-7 model from 1994.', 550.00, 6, 'https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp'),
('Hot Wheels 2021 Corvette C8.R', 'Latest Corvette racing model with authentic details.', 275.50, 8, 'https://i.ebayimg.com/images/g/vvwAAOSwH4VkYvLb/s-l1600.jpg'),
('Hot Wheels Tesla Model S Plaid', 'Electric supercar with premium finish.', 425.00, 5, 'https://i.ebayimg.com/images/g/qWIAAOSwPpVlUq3~/s-l1600.jpg'),
('Hot Wheels 1967 Camaro SS', 'Classic muscle car with metallic paint.', 599.99, 4, 'https://i.ebayimg.com/images/g/q4QAAOSwKjFlgWxp/s-l1600.jpg'),
('Hot Wheels Honda Civic Type R', 'JDM legend with racing livery.', 325.75, 10, 'https://i.ebayimg.com/images/g/~SkAAOSwFYBkYvLc/s-l1600.jpg'),
('Hot Wheels Bugatti Chiron', 'Hypercar with premium details.', 750.00, 3, 'https://i.ebayimg.com/images/g/gqEAAOSwvd5kYvLb/s-l1600.jpg'),
('Hot Wheels Aston Martin DB5', 'Classic British luxury sports car.', 475.50, 7, 'https://i.ebayimg.com/images/g/q4QAAOSwKjFlgWxp/s-l1600.jpg'),
('Hot Wheels Pagani Huayra', 'Italian masterpiece with gull-wing doors.', 625.00, 4, 'https://i.ebayimg.com/images/g/gqEAAOSwvd5kYvLb/s-l1600.jpg'),
('Hot Wheels 1970 Plymouth Superbird', 'NASCAR legend with iconic wing.', 585.25, 6, 'https://i.ebayimg.com/images/g/vvwAAOSwH4VkYvLb/s-l1600.jpg'),
('Hot Wheels Koenigsegg Agera R', 'Swedish hypercar with record-breaking speed.', 699.99, 3, 'https://i.ebayimg.com/images/g/qWIAAOSwPpVlUq3~/s-l1600.jpg'),
('Hot Wheels Mercedes-AMG GT', 'German engineering at its finest.', 450.00, 8, 'https://i.ebayimg.com/images/g/~SkAAOSwFYBkYvLc/s-l1600.jpg'),
('Hot Wheels Dodge Challenger Demon', 'Modern muscle car with drag racing setup.', 525.75, 5, 'https://i.ebayimg.com/images/g/q4QAAOSwKjFlgWxp/s-l1600.jpg'),
('Hot Wheels Porsche 918 Spyder', 'Hybrid hypercar with racing heritage.', 675.00, 4, 'https://i.ebayimg.com/images/g/gqEAAOSwvd5kYvLb/s-l1600.jpg'),
('Hot Wheels McLaren Senna', 'Track-focused hypercar with active aero.', 725.50, 3, 'https://i.ebayimg.com/images/g/vvwAAOSwH4VkYvLb/s-l1600.jpg'),
('Hot Wheels Ford GT40', 'Le Mans winning legend.', 599.99, 6, 'https://i.ebayimg.com/images/g/qWIAAOSwPpVlUq3~/s-l1600.jpg'); 