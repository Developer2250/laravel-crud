The project aims to develop a web application that facilitates the management of categories and products using Laravel as the backend framework and AdminLTE as the admin panel. The application will allow users to perform CRUD (Create, Read, Update, Delete) operations on categories and products, with a focus on establishing a relationship between them.

## Key Features:

1. User Authentication:
Users will be required to log in to access the admin panel.
User roles may include admin and other roles as needed.

2. AdminLTE Admin Panel:
Integration of AdminLTE admin panel to provide an intuitive and responsive user interface for managing categories and products.

3. Category Management:
CRUD operations for categories, including adding, editing, and deleting categories.
Each category will have attributes such as name, description, and any additional attributes needed.

4. Product Management:
CRUD operations for products, including adding.
Each product will be associated with a category.
Product attributes may include name, description, price, quantity, etc.

5. Relationships:
Establish a relationship between categories and products (e.g., one-to-many or many-to-many). This ensures that products are assigned to specific categories.

6. Listing and Pagination:
Using DataTables Display paginated lists of categories and products in the admin panel.
Provide search and filter options for efficient data retrieval.

7. Validation and Error Handling:
Implement form validation to ensure data integrity.
Handle errors gracefully and provide meaningful error messages.

8. Security Measures:
Implement security measures, including CSRF protection, input validation, and proper authentication authorization.

9. Technologies Used:
Laravel: As the backend framework for PHP.
AdminLTE: A popular open-source admin dashboard and control panel theme.
MySQL or another database of choice for storing category and product data.
Laravel Eloquent for handling database interactions.
Blade templating engine for creating views.

## Outcome:
The project will result in a functional web application that allows administrators to efficiently manage categories and products through an intuitive and responsive admin panel. The CRUD operations and the relationship between categories and products contribute to a well-organized and structured data management system. The integration of AdminLTE enhances the user experience by providing a modern and visually appealing interface.

### Prerequisites
What is needed to set up the dev environment. For instance, global dependencies or any other tools. include download links.

### Setting up Dev

Here's a brief intro about what a developer must do in order to start developing
the project further:

```shell

composer install

npm install --save

php artisan migrate

```
## Here is some Snap-shot for the project
1. Login Page:
[![ZPv-ZNq-Fo-RQSWz-GGBCk-2g.png](https://i.postimg.cc/g0jndxsY/ZPv-ZNq-Fo-RQSWz-GGBCk-2g.png)](https://postimg.cc/2qpz78gJ)

2. Register Page:
[![8r-Ijh9-IRWa6qlhhw1l-QIQ.png](https://i.postimg.cc/zDFRz9Wv/8r-Ijh9-IRWa6qlhhw1l-QIQ.png)](https://postimg.cc/ThhPQNtv)

3. Dashboard Page:
[![ZPVJGwqi-Q-6yj-Rpc-P-y6q-Q.png](https://i.postimg.cc/G27tY1jx/ZPVJGwqi-Q-6yj-Rpc-P-y6q-Q.png)](https://postimg.cc/0MS9RFFz)

4. Category Page:
[![URd-GJkk8-SXm10-J4-b-ZSihg.png](https://i.postimg.cc/Kc33LRdK/URd-GJkk8-SXm10-J4-b-ZSihg.png)](https://postimg.cc/0rxN125x)

5. Log data
[![v-Wt-Ve-Zi-Qk-Wu-Svm9renq-Hw.png](https://i.postimg.cc/65YKphYC/v-Wt-Ve-Zi-Qk-Wu-Svm9renq-Hw.png)](https://postimg.cc/CzBXvbyK)

6. Modify data
[![U-U56q4-WQZWFbcq6-J8740-Q.png](https://i.postimg.cc/pVBbsZN3/U-U56q4-WQZWFbcq6-J8740-Q.png)](https://postimg.cc/fkkrLYRv)



## Licensing

State what the license is and how to find the text version of the license.