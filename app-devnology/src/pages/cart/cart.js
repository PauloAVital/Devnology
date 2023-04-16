

import { useState } from "react"

const Cart = (props) => {
   console.log('222', props)

  const [produtos, setProdutos] = useState([])

/* setProdutos([...produtos, {...props}]) */

const list = []
   return (
    <>
        <h1>Compras realizadas</h1>
        <table border="1">
            <tr>
                <td>produto</td>
                <td>preço</td>
            </tr>
            {list.map((item)=> {
                return <tr>
                    <td>{item.name}</td>
                    <td>{item.preco}</td>
                </tr>
            })}
        </table>
    </>
)
}

export default Cart