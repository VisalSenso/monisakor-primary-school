import { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";

const Staff = () => {
    const [staff, setStaff] = useState([]);
    const [managementCommittee, setManagementCommittee] = useState([]);
    const { t,i18n } = useTranslation();

    useEffect(() => {
        const language = i18n.language;
        fetch(`http://localhost/project/monisakor-primary-school/server/api/Staff_and_management_committee.php?lang=${i18n.language}`)
            .then((response) => response.json())
            .then((data) => {
                setStaff(data.staff);
                setManagementCommittee(data.management_committee);
            })
            .catch((error) => console.error("Error fetching data:", error));
    }, [i18n.language]);

    return (
        <div className="py-24 sm:py-32">
            <div className="mx-auto grid max-w-7xl gap-20 px-6 lg:px-8 xl:grid-cols-3">
                {/* Management Committee Section */}
                <div className="max-w-xl">
                    <h2 className="text-3xl font-semibold tracking-tight text-primary sm:text-4xl">
                        {t("committee")}
                    </h2>
                    {/* <p className="mt-6 text-lg text-gray-600">
                        Our management committee ensures smooth operations and strategic planning for our institution.
                    </p> */}
                </div>
                <ul role="list" className="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
                    {managementCommittee.map((member, index) => (
                        <li key={member.id || index}> {/* ✅ FIXED: Using unique key */}
                            <div className="flex items-center gap-x-6">
                                <img alt={member.name}
                                    src={
                                        member.imageUrl
                                            ? `http://localhost/project/monisakor-primary-school/assects/images/pta/${member.imageUrl.replace(
                                                /^.*[\\\/]/,
                                                ""
                                            )}`
                                            : "https://via.placeholder.com/150"
                                    }
                                    className="size-16 object-cover rounded-full"
                                />
                                <div>
                                    <h3 className="text-base font-semibold tracking-tight  text-gray-800 dark:text-gray-200">{member.name}</h3>
                                    <p className="text-sm font-semibold text-gray-600 dark:text-gray-300">{member.role}</p>
                                    <p className="text-sm font-semibold text-gray-600 dark:text-gray-300"><span>{t("tel")} </span>{member.contact}</p>
                                </div>
                            </div>
                        </li>
                    ))}
                </ul>
            </div>

            <hr className="my-12 h-px border-t-0 bg-transparent bg-gradient-to-r from-transparent via-neutral-500 to-transparent opacity-25 dark:via-neutral-300" />

            <div className="mx-auto grid max-w-7xl gap-20 px-6 lg:px-8 xl:grid-cols-3 mt-16">
                {/* Staff Section */}
                <div className="max-w-xl">
                    <h2 className="text-3xl font-semibold tracking-tight text-secondary sm:text-4xl">
                        {t("staff")}
                    </h2>
                    {/* <p className="mt-6 text-lg text-gray-600">
                        We're a dynamic group of individuals who are passionate about what we do and dedicated to delivering the best results.
                    </p> */}
                </div>
                <ul role="list" className="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
                    {staff.map((person, index) => (
                        <li key={person.id || index}> {/* ✅ FIXED: Using unique key */}
                            <div className="flex items-center gap-x-6">
                                <img alt={person.name}
                                    src={
                                        person.imageUrl
                                            ? `http://localhost/project/monisakor-primary-school/assects/images/staff/${person.imageUrl.replace(
                                                /^.*[\\\/]/,
                                                ""
                                            )}`
                                            : "https://via.placeholder.com/150"
                                    }
                                    className="size-16 object-cover rounded-full"
                                />
                                <div>
                                    <h3 className="text-base font-semibold tracking-tight text-gray-800 dark:text-gray-200">{person.name}</h3>
                                    <p className="text-sm font-semibold text-gray-600 dark:text-gray-300">{person.role}</p>
                                    <p className="text-sm font-semibold text-gray-600 dark:text-gray-300"><span>Phone: </span>{person.contact}</p>
                                </div>
                            </div>
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
};

export default Staff;
