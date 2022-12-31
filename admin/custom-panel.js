/**
 * Override the default edit UI to include a new block inspector control for
 * adding our custom control.
 *
 * @param {function|Component} BlockEdit Original component.
 *
 * @return {string} Wrapped component.
 */
export const addMyCustomBlockControls = createHigherOrderComponent( ( BlockEdit ) => {

    return ( props ) => {

        // If this block supports scheduling and is currently selected, add our UI
        if ( isValidBlockType( props.name ) && props.isSelected ) {
            return (
                <Fragment>
                    <BlockEdit { ...props } />
                    <InspectorControls>
                        <PanelBody title={ __( 'My Custom Panel Heading' ) }>
                            <TextControl
                                label={ __( 'My Custom Control' ) }
                                help={ __( 'Some help text for my custom control.' ) }
                                value={ props.attributes.scheduledStart || '' }
                                onChange={ ( nextValue ) => {
                                    props.setAttributes( {
                                        scheduledStart: nextValue,
                                    } );
                                } } />
                        </PanelBody>
                    </InspectorControls>
                </Fragment>
            );
        }

        return <BlockEdit { ...props } />;
    };
}, 'addMyCustomBlockControls' );

addFilter( 'editor.BlockEdit', 'my-plugin/my-control', addMyCustomBlockControls );