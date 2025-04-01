import { useState } from 'react';

import {FormGroup, Label, Input, Button, Modal, ModalHeader, ModalBody, ModalFooter} from 'reactstrap';

import { ToastContainer, Bounce } from 'react-toastify';

import ForgotPassword  from './ForgotPassword';

export default function Login() {

  const [ email, setEmail ] = useState('')
  const [ password, setPassword ] = useState('');

  const handleSubmit = () => {

  }

  

  return (
    <div className="login-wrapper">
      <div className="pt-[100px]">
        <div className="login-container">
            <h1>Login to your account</h1>
            <p>Please enter your details below</p>
            <FormGroup>
                <Label>Email</Label>
                <Input type="text" placeholder="Email Address" value={email} onChange={ (e) => setEmail(e.target.value) } name="username" />
            </FormGroup>
            <FormGroup>
                <Label>Password</Label>
                <Input type="password" placeholder="Password" value={ password } onChange={ (e) => setPassword(e.target.value)  } name="password" />
            </FormGroup>
            <Button onClick={ handleSubmit } color="primary">Login</Button>
            <ForgotPassword />
        </div>
        </div>
        <ToastContainer
          position="top-right"
          autoClose={5000}
          hideProgressBar={false}
          newestOnTop={false}
          closeOnClick={false}
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
          theme="light"
          transition={Bounce}
        />
    </div>
  )

}