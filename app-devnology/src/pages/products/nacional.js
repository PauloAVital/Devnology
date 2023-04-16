import React, { Component, useState, useEffect } from 'react'
import axios from "axios";
import SelectNacional from './SelectNacional';


function Nacional() {
    

    const [user, setUser] = useState();
    const [categoryProducts, setCategoryProducts] = useState('');


    const api = axios.create({
        baseURL: "https://616d6bdb6dacbb001794ca17.mockapi.io/"
    })

    useEffect(() => {
        api
            .get("devnology/brazilian_provider")
            .then((response) => setUser(response.data))
            .catch((err) => {
                console.error("Verifique o erro "+ err)
            });
    }, []);

    const onProductsSelectchange = (evento) => {
        const linkValue = evento.target.value
        setCategoryProducts(linkValue)
        console.log(linkValue)
    }

    function AddCart(id, desconto, newvalue) {
       
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
                <SelectNacional user={user}/>

            </select>
            <div className="row">
                
            {user?.map((users, index) => {
                if (categoryProducts == '') {
                    return <div className="column">
                                <div className="card">
                                    <img src={users.imagem} />
                                    <h1>{users.nome}</h1>
                                    <p className="price">{users.preco}</p>
                                    <p className="description">{users.descricao}</p>
                                    <p><button onClick={() => AddCart(
                                                users.id,
                                                users.nome,
                                                users.preco
                                                )}>Adicionar ao Carrinho
                                            </button></p>
                                </div>
                            </div>
                } else {
                    if (categoryProducts == users.categoria ) {
                      return <div className="column">
                                <div className="card">
                                    <img src={users.imagem} />
                                    <h1>{users.nome}</h1>
                                    <p className="price">{users.preco}</p>
                                    <p className="description">{users.descricao}</p>
                                    <p><button onClick={() => AddCart(
                                                users.id,
                                                users.nome,
                                                users.preco
                                                )}>Adicionar ao Carrinho
                                            </button></p>
                                </div>
                            </div>  
                    }
                }
                                  
                })}
            
            </div>
        </div>
    )
}

export default Nacional