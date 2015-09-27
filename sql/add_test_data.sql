-- User-taulun testidata
INSERT INTO Users (username, password, admin) VALUES ('admin', '1234', true);
INSERT INTO Users (username, password, admin) VALUES ('normalUser', '1234', false);

-- ItemType-taulun testidata
INSERT INTO ItemType (name, pnPrefix, nextPN) VALUES ('Resistor', 'RES', 3);
INSERT INTO ItemType (name, pnPrefix, nextPN) VALUES ('Capacitor', 'CAP', 2);

-- Item-taulun testidata
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('RES-000000', '10k, 5%, 100ppm, 100mW, 50V, 0805', 1);
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('RES-000001', '100k, 5%, 100ppm, 100mW, 50V, 0805', 1);
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('RES-000002', '1M, 5%, 100ppm, 100mW, 50V, 0805', 1);
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('CAP-000000', '10n, 10%, 100V, X7R, 0805', 2);
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('CAP-000001', '100n, 10%, 100V, X7R, 0805', 2);

-- VendorItem-taulun testidata
INSERT INTO Vendor (name) VALUES ('Panasonic');

-- VendorItem-taulun testidata
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('ERA-S15J103V', 'http://', 1);

-- VendorItem-taulun testidata
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (1, 1);
