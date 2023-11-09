from flask import Flask, jsonify, request

app = Flask(__name__)

from products import products

#WELCOME
@app.route('/welcome', methods = ['GET'])
def getwelcome():
    return jsonify({
        'message':'Welcome to REST API'
        })


@app.route('/products', methods = ['GET'])
def getproducts():
    return jsonify({
        'products': products, 
        'message': 'Products List'
        })



@app.route('/products/<string:products_name>', methods = ['GET'])
def getproduct(products_name):
    productsFound = [product for product in products if product['name'] == products_name]
    if (len(productsFound) > 0):
        return jsonify({'product': productsFound[0]})
    return jsonify({
        'message': 'Products not found'
        })



@app.route('/products', methods=['POST'])
def addProducts():
    new_product = {
        'name': request.json['name'],
        'price': request.json['price'],
        'quantity': request.json['quantity']
    }
    products.append(new_product)
    return jsonify({
        'message': 'Product added Succesfully', 
        'products': products
        })



#UPDATE
@app.route('/products/<string:product_name>', methods = ['PUT'])
def editProduct(product_name):
    productsFound = [product for product in products if product['name'] == product_name]
    if (len(productsFound) > 0):
        productsFound[0]['name'] = request.json['name']
        productsFound[0]['price'] = request.json['price']
        productsFound[0]['quantity'] = request.json['quantity']
        return jsonify({
            'message': 'Product Updated',
            'product': productsFound[0]
        })
    return jsonify[{
        'message': 'Product not found'
        }]

@app.route('/products/<string:product_name>', methods = ['DELETE'])
def deleteProduct(product_name):
    productsFound = [product for product in products if product['name'] == product_name]
    if(len(productsFound) > 0):
        products.remove(productsFound[0])
        return jsonify({
            'message': 'Product Deleted',
            'products': products
        })
    return jsonify({
        'message': 'Product not found'
    })


if __name__ == '__main__':
    app.run(debug = True, port = 4000)