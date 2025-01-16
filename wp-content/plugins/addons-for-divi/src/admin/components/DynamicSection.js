import {__} from '@wordpress/i18n';
import PropTypes from 'prop-types';

const DynamicSection = ({title, children}) => {
    return (
        <section className="block px-6 py-8 border-b border-solid border-de-medium-gray">
            <div className="mr-16 w-full flex items-center">
                <h3 className="p-0 flex-1 justify-right inline-flex text-lg leading-8 font-medium">{title}</h3>
            </div>

            <div className="mt-4">{children}</div>
        </section>
    );
};

// Define prop types for dynamic content
DynamicSection.propTypes = {
    title: PropTypes.string.isRequired,
    children: PropTypes.node.isRequired,
};

export default DynamicSection;
