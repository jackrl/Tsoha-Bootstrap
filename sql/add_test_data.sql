-- ItemType-taulun testidata
INSERT INTO ItemType (name, pnPrefix, nextPN) VALUES ('Resistor', 'RES', 1);
INSERT INTO ItemType (name, pnPrefix, nextPN) VALUES ('Printed Circuit Board Assembly', 'PCBA', 1);

-- Item-taulun testidata
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('RES-000000', '10k, 5%, 100ppm, 100mW, 50V, 0805', 1);
INSERT INTO Item (partNumber, description, hasBOM, itemtype_id) VALUES ('PCBA-000000', 'Resistor Board', TRUE, 2);

-- PartsList-taulun testidata
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R1');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R2');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R3');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R4');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R5');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R6');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R7');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R8');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R9');
INSERT INTO PartsList (parent_id, child_id, refDes) VALUES (2, 1, 'R10');

-- VendorItem-taulun testidata
INSERT INTO Vendor (name) VALUES ('Panasonic');

-- VendorItem-taulun testidata
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('ERA-S15J103V', 'http://', 1);

-- VendorItem-taulun testidata
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (1, 1);
