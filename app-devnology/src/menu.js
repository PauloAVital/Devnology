import { Routes, Route, Link}  from "react-router-dom";
import React, { Component, useState, useEffect } from 'react'
import Home from "./pages/home/Home"
import Importado from "./pages/products/Importado";
import Nacional from "./pages/products/nacional";
import Cart from "./pages/cart/cart";

const Menu = () => {

    return (
    <>
        <nav class="menu">
            <h1><img src='img/Devnology.png' className="logo"/></h1>
            <ul>
                <li>
                    <Link to="/">
                        Principal
                    </Link>
                </li>
                <li><a href="#">Produtos</a>
                    <ul>
                    <li>
                        <Link to="/nacional">
                            Nacional
                        </Link>
                    </li>
                        <li>
                            <Link to="/importado">
                                Importado
                            </Link>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Carrinho (0)</a>
                    <ul>
                        <li>
                            <Link to="/cart">
                                Carrinho
                            </Link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <Routes>            
            <Route path="nacional" element={<Nacional />} />
            <Route path="importado" element={<Importado />} />
            <Route path="cart" element={<Cart />} />
            <Route path="home" element={<Home />} />
        </Routes>
    </>
    )
}

export default Menu