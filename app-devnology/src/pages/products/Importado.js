import React, { Component, useState, useEffect } from 'react'
import axios from "axios";
import SelectImportado from './SelectImportado';
import Cart from '../cart/cart';


function Importado() {
    

        const [user, setUser] = useState();
        const [categoryProducts, setCategoryProducts] = useState('');
        const [id, setId] = useState();
        const [desconto, setDesconto] = useState();
        const [newvalue, setNewvalue] = useState();


        const api = axios.create({
            baseURL: "https://616d6bdb6dacbb001794ca17.mockapi.io/"
        })

        useEffect(() => {
            api
                .get("devnology/european_provider")
                .then((response) => setUser(response.data))
                .catch((err) => {
                    console.error("Verifique o erro "+ err)
                });
        }, []);

        const onProductsSelectchange = (evento) => {
            const linkValue = evento.target.value
            setCategoryProducts(linkValue)
        }
    
        function AddCart(id, desconto, newvalue) {
            console.log(id, desconto, newvalue)
        }

        

        return (
            <div>
                <select
                    id="selectCategoria"
                    name="selectCategoria"
                    value={categoryProducts}
                    onChange={onProductsSelectchange}
                >
                    <option>Categoria</option>
                    <SelectImportado user={user}/>
    
                </select>
                
                <div className="row">
                    
                {user?.map((users, index) => {
                    const newvalue = (users.hasDiscount) ? 
                        (users.price - users.discountValue) : users.price
                    const desconto = (users.hasDiscount) ? 
                        <p className="desconto"> Desconto de {users.discountValue} </p> : ''
                    const preco =  (users.hasDiscount) ? 
                        <p className="price">{users.price}</p> : ''


                    if (categoryProducts == '') {
                        return <div className="column">
                                    <div className="card">
                                        <img src={users.gallery[0]} />
                                        <h1>{users.name}</h1>
                                        {preco}
                                        {desconto}
                                        <p className="price">{newvalue}</p>
                                        <p className="description">{users.description}</p>
                                        <p>
                                            <button onClick={() => AddCart(
                                                users.id,
                                                users.name,
                                                users.discountValue,
                                                newvalue
                                                )}>Add to Cart
                                            </button>
                                        </p>
                                    </div>
                                </div>
                    } else {
                        if (categoryProducts == users.details.adjective ) {
                          return <div className="column">
                                    <div className="card">
                                        <img src={users.gallery[0]} />
                                        <h1>{users.name}</h1>
                                        {preco}
                                        {desconto}                                        
                                        <p className="price">{newvalue}</p>
                                        <p className="description">{users.description}</p>
                                        <p>
                                            <button onClick={() => AddCart(
                                                users.id,
                                                users.name,
                                                users.discountValue,
                                                newvalue
                                                )}>Add to Cart
                                            </button>
                                        </p>
                                    </div>
                                </div>  
                        }
                    }
                                      
                    })}
                
                </div>
            </div>
        )
}

export default Importado