-- User-taulun testidata
INSERT INTO Users (username, password, admin) VALUES ('admin', '1234', true);
INSERT INTO Users (username, password, admin) VALUES ('user1', '1234', false);
INSERT INTO Users (username, password, admin) VALUES ('admin2', '1234', true);
INSERT INTO Users (username, password, admin) VALUES ('user2', '1234', false);

-- ItemType-taulun testidata
INSERT INTO ItemType (name, pnPrefix, nextPN) VALUES ('Resistor', 'RES', 2);
INSERT INTO ItemType (name, pnPrefix, nextPN) VALUES ('Logic Circuit', 'LOG', 1);

-- Item-taulun testidata
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('RES-000000', '10k, 1%, 100ppm, 125mW, 0805', 1);
INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('RES-000001', '100k, 1%, 100ppm, 125mW, 0805', 1);

INSERT INTO Item (partNumber, description, itemtype_id) VALUES ('LOG-000000', 'AND Gate, 4ch, SOIC-14, W3.9mm', 2);

-- VendorItem-taulun testidata
INSERT INTO Vendor (name) VALUES ('Yageo');
INSERT INTO Vendor (name) VALUES ('Stackpole');
INSERT INTO Vendor (name) VALUES ('Panasonic');
INSERT INTO Vendor (name) VALUES ('Texas Instruments');
INSERT INTO Vendor (name) VALUES ('NXP Semiconductors');
INSERT INTO Vendor (name) VALUES ('ON Semiconductor');

-- VendorItem-taulun testidata
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('RC0805FR-0710KL',
																	 'http://www.mouser.com/ds/2/447/RC0805-257173.pdf',
																	 1);
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('RMCF0805FT10K0',
																	 'https://www.seielect.com/Catalog/SEI-RMCF_RMCP.pdf',
																	 2);
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('ERJ-6ENF1002V',
																	 'http://industrial.panasonic.com/ww/products/resistors/chip-resistors/chip-resistors/precision-thick-film-chip-resistors/ERJ6ENF1002V',
																	 3);

INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('RC0805FR-07100KL',
																	 'http://www.mouser.com/ds/2/447/RC0805-257173.pdf',
																	 1);
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('RMCF0805FT100K',
																	 'https://www.seielect.com/Catalog/SEI-RMCF_RMCP.pdf',
																	 2);
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('ERJ-6ENF1003V',
																	 'http://industrial.panasonic.com/ww/products/resistors/chip-resistors/chip-resistors/precision-thick-film-chip-resistors/ERJ6ENF1002V',
																	 3);

INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('74HC08D,653',
																	 'http://www.nxp.com/documents/data_sheet/74HC_HCT08.pdf',
																	 5);
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('CD4081BM96',
																	 'http://www.ti.com/lit/ds/symlink/cd4073b.pdf',
																	 4);
INSERT INTO VendorItem (partNumber, datasheetUrl, vendor_id) VALUES ('MC14081BDR2G',
																	 '',
																	 6);

-- VendorItem-taulun testidata
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (1, 1);
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (1, 2);
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (1, 3);

INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (2, 4);
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (2, 5);
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (2, 6);

INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (3, 7);
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (3, 8);
INSERT INTO ItemToVendorItemMap (item_id, vendorItem_id) VALUES (3, 9);