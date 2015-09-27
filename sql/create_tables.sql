CREATE TABLE Users(
	id SERIAL PRIMARY KEY,
	username varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	admin boolean DEFAULT FALSE
);

CREATE TABLE ItemType(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	pnPrefix varchar(5) NOT NULL,
	nextPN INTEGER DEFAULT 0
);

CREATE TABLE Item(
	id SERIAL PRIMARY KEY,
	partNumber varchar(15) NOT NULL,
	description varchar(100) NOT NULL,
	itemtype_id INTEGER REFERENCES ItemType(id)
);

CREATE TABLE Vendor(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL
);

CREATE TABLE VendorItem(
	id SERIAL PRIMARY KEY,
	partNumber varchar(30) NOT NULL,
	datasheetUrl text,
	vendor_id INTEGER REFERENCES Vendor(id)
);

CREATE TABLE ItemToVendorItemMap(
	id SERIAL PRIMARY KEY,
	item_id INTEGER REFERENCES Item(id),
	vendorItem_id INTEGER REFERENCES VendorItem(id)
);
