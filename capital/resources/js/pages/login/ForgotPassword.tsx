import {Fragment, useState } from 'react';
import { Modal, ModalHeader, ModalBody, ModalFooter, Label, FormGroup, Input, Button } from 'reactstrap';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import { faPaperPlane, faBan } from '@fortawesome/free-solid-svg-icons'

import Authservice from '@/components/Autservice';

import { validateEmail } from '@/components/Functions';
export default function ForgotPassword() {

    const [ open, setOpen ] = useState( false );
    const [ sent, sendForgotPassword ] = useState( false )

    const [ errorEmail, setError ] = useState( false);

    const [ email, setEmail ] = useState( 'celsomalacasjr@gmail.com' );

    const changeEmail = (email) => {


        setEmail( email );
        setError( false );

    }

    const submit = () => {

        let valid = true;

        let error = false;

        if (!validateEmail( email )) {

            valid = false;
            error = true;

        }

        if (valid) {

            Authservice.posts('/forgot-password', { email } );
            setOpen( false )
            // setEmail( '' )

        } else {

            setError( error );

        }

    }

      return (
          <Fragment>

              <div onClick={ () => setOpen( true )} style={{cursor: 'pointer'}} className="forgot-password text-primary text-underline">Forgot Password?</div>
              <Modal isOpen={ open } toggle={ () => setOpen( false ) } className="mw-100 w-50">
                  <ModalHeader>
                      Forgot Password
                  </ModalHeader>
                  <ModalBody>
                      { sent ?

                          <p className="text-center">Email sent to your email address with your new password</p>

                      : 
                          <Fragment>

                              { errorEmail ? <div className="alert alert-danger">Please enter a valid email address</div> : '' }
                              <FormGroup>
                                  <Label>Enter your email address, new password will sent to your email address:</Label>
                                  <Input type="text" value={ email } name="email" onChange={ (e) => changeEmail(e.target.value) } />                            
                              </FormGroup>

                          </Fragment>                            

                      }

                  </ModalBody>
                  <ModalFooter>
                      { sent ?

                          <Button onClick={() => setOpen( false ) } color="success"><FontAwesomeIcon icon={faBan} /> Close</Button>

                      : 

                      <Fragment>
                          <Button onClick={() => submit() } color="primary"><FontAwesomeIcon icon={faPaperPlane} /> Submit</Button>
                          <Button onClick={() => setOpen( false )} color="light"><FontAwesomeIcon icon={faBan} /> Cancel</Button>
                      </Fragment>

                      }
                      
                  </ModalFooter>
              </Modal>

          </Fragment>
      )

}